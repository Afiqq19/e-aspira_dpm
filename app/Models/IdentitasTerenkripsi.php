<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class IdentitasTerenkripsi extends Model
{
    use HasFactory;

    protected $table = 'identitas_terenkripsi';

    /**
     * PENTING: Jangan tambahkan fillable 'data_terenkripsi' secara langsung.
     * Gunakan method setIdentitas() untuk enkripsi otomatis.
     */
    protected $fillable = [
        'pengaduan_id',
        'data_terenkripsi',
        'encrypted_key_ref',
        'diakses_pada',
        'diakses_oleh',
    ];

    protected $casts = [
        'diakses_pada' => 'datetime',
    ];

    /**
     * Sembunyikan data_terenkripsi dari serialisasi JSON/array
     * untuk mencegah kebocoran data tidak sengaja
     */
    protected $hidden = [
        'data_terenkripsi',
    ];

    // =====================================================================
    // RELASI
    // =====================================================================

    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class);
    }

    public function diaksesoleh()
    {
        return $this->belongsTo(User::class, 'diakses_oleh');
    }

    // =====================================================================
    // ENKRIPSI / DEKRIPSI (AES-256 via Laravel Crypt)
    // =====================================================================

    /**
     * Simpan data identitas dalam format terenkripsi AES-256
     *
     * @param array $identitas ['nama' => '...', 'nim' => '...', 'email' => '...', 'no_hp' => '...']
     */
    public function setIdentitas(array $identitas): void
    {
        $this->data_terenkripsi = Crypt::encryptString(json_encode($identitas));
        $this->encrypted_key_ref = 'APP_KEY_' . substr(config('app.key'), -8);
    }

    /**
     * Dekripsi dan kembalikan data identitas asli
     * HANYA panggil setelah verifikasi permission 'penanganan_kasus_sensitif'
     *
     * @return array|null
     */
    public function getIdentitas(): ?array
    {
        if (!$this->data_terenkripsi) {
            return null;
        }

        try {
            return json_decode(Crypt::decryptString($this->data_terenkripsi), true);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            \Log::error("Gagal mendekripsi identitas pengaduan #{$this->pengaduan_id}: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Catat akses ke identitas sensitif (wajib dipanggil setiap buka identitas)
     */
    public function catatAkses(User $user): void
    {
        $this->update([
            'diakses_pada' => now(),
            'diakses_oleh' => $user->id,
        ]);

        // Log ke activity log Spatie
        activity('akses_identitas_sensitif')
            ->causedBy($user)
            ->performedOn($this->pengaduan)
            ->withProperties([
                'ticket_code' => $this->pengaduan->ticket_code,
                'diakses_oleh_nama' => $user->nama,
                'diakses_oleh_id' => $user->id,
                'waktu_akses' => now()->toIso8601String(),
            ])
            ->log("Identitas asli pelapor dibuka oleh {$user->nama} ({$user->email})");
    }
}
