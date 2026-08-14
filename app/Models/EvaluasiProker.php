<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluasiProker extends Model
{
    use HasFactory;

    protected $table = 'evaluasi_proker';

    protected $fillable = [
        'program_kerja_id',
        'user_id',
        'rating',
        'komentar',
        'aspek',
        'is_anonim',
    ];

    protected $casts = [
        'is_anonim' => 'boolean',
    ];

    public function programKerja()
    {
        return $this->belongsTo(ProgramKerja::class, 'program_kerja_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
