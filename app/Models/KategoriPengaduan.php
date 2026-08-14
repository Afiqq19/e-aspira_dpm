<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriPengaduan extends Model
{
    use HasFactory;

    protected $table = 'kategori_pengaduan';

    protected $fillable = [
        'nama_kategori',
        'level_sensitivitas',
        'deskripsi',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // =====================================================================
    // RELASI
    // =====================================================================

    public function pengaduans()
    {
        return $this->hasMany(Pengaduan::class, 'kategori_id');
    }

    // =====================================================================
    // SCOPES
    // =====================================================================

    public function scopeSensitif($query)
    {
        return $query->where('level_sensitivitas', 'sensitif');
    }

    public function scopeNormal($query)
    {
        return $query->where('level_sensitivitas', 'normal');
    }

    public function scopeAktif($query)
    {
        return $query->where('is_active', true);
    }

    // =====================================================================
    // HELPERS
    // =====================================================================

    public function isSensitif(): bool
    {
        return $this->level_sensitivitas === 'sensitif';
    }
}
