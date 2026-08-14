<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Pengaduan extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $table = 'pengaduan';

    protected $fillable = [
        'ticket_code',
        'user_id',
        'kategori_id',
        'isi',
        'mode_privasi',
        'status',
        'penanganan_khusus',
        'kode_anonim',
        'alasan_penolakan',
        'ditangani_pada',
    ];

    protected $casts = [
        'penanganan_khusus' => 'boolean',
        'ditangani_pada' => 'datetime',
    ];

    // =====================================================================
    // ACTIVITY LOG — Hanya log field non-sensitif
    // =====================================================================

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['ticket_code', 'status', 'mode_privasi', 'kategori_id', 'penanganan_khusus'])
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn (string $eventName) => "Pengaduan {$this->ticket_code} di-{$eventName}");
    }

    // =====================================================================
    // RELASI
    // =====================================================================

    /**
     * Pelapor (nullable jika anonim)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Kategori pengaduan
     */
    public function kategori()
    {
        return $this->belongsTo(KategoriPengaduan::class, 'kategori_id');
    }

    /**
     * Identitas terenkripsi (tabel TERPISAH — hanya untuk mode anonim)
     */
    public function identitasTerenkripsi()
    {
        return $this->hasOne(IdentitasTerenkripsi::class);
    }

    /**
     * Riwayat tanggapan (komunikasi dua arah)
     */
    public function tanggapans()
    {
        return $this->hasMany(TanggapanPengaduan::class)->orderBy('created_at');
    }

    /**
     * Tanggapan publik (bisa dilihat pelapor)
     */
    public function tanggapansPublik()
    {
        return $this->hasMany(TanggapanPengaduan::class)
            ->where('is_internal', false)
            ->orderBy('created_at');
    }

    // =====================================================================
    // SCOPES
    // =====================================================================

    public function scopeUmum($query)
    {
        return $query->where('mode_privasi', 'umum');
    }

    public function scopeAnonim($query)
    {
        return $query->where('mode_privasi', 'anonim');
    }

    public function scopeSensitif($query)
    {
        return $query->where('penanganan_khusus', true);
    }

    public function scopeTidakSensitif($query)
    {
        return $query->where('penanganan_khusus', false);
    }

    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    public function scopeBelumSelesai($query)
    {
        return $query->whereNotIn('status', ['selesai', 'ditolak']);
    }

    // =====================================================================
    // HELPERS
    // =====================================================================

    /**
     * Generate ticket code unik format PLP-YYYY-XXXX
     */
    public static function generateTicketCode(): string
    {
        $year = date('Y');
        do {
            $randomNumber = str_pad(random_int(1, 9999), 4, '0', STR_PAD_LEFT);
            $code = "PLP-{$year}-{$randomNumber}";
        } while (static::where('ticket_code', $code)->exists());

        return $code;
    }

    /**
     * Generate kode anonim acak
     */
    public static function generateKodeAnonim(): string
    {
        return 'ANON-' . strtoupper(substr(md5(uniqid()), 0, 8));
    }

    /**
     * Nama yang ditampilkan (kode anonim atau nama asli)
     */
    public function getNamaPelaporAttribute(): string
    {
        if ($this->mode_privasi === 'anonim') {
            return $this->kode_anonim ?? 'Anonim';
        }
        return $this->user?->nama ?? 'Tidak Diketahui';
    }

    /**
     * Label status dalam Bahasa Indonesia
     */
    public function getLabelStatusAttribute(): string
    {
        return match ($this->status) {
            'diterima'        => 'Diterima',
            'diverifikasi'    => 'Diverifikasi',
            'diproses'        => 'Sedang Diproses',
            'ditindaklanjuti' => 'Ditindaklanjuti',
            'selesai'         => 'Selesai',
            'ditolak'         => 'Ditolak',
            default           => $this->status,
        };
    }

    /**
     * Badge color untuk status
     */
    public function getWarnaBadgeStatusAttribute(): string
    {
        return match ($this->status) {
            'diterima'        => 'blue',
            'diverifikasi'    => 'indigo',
            'diproses'        => 'yellow',
            'ditindaklanjuti' => 'orange',
            'selesai'         => 'green',
            'ditolak'         => 'red',
            default           => 'gray',
        };
    }
}
