<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UuKema extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'file_path',
        'is_active',
    ];
}
