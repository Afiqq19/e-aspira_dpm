<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Pengumuman extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $table = 'pengumuman';

    protected $fillable = [
        'judul',
        'isi',
        'organisasi_id',
        'user_id',
        'kategori',
        'tags',
        'is_pinned',
        'lampiran',
        'dipublikasikan_pada',
        'status',
    ];

    protected $casts = [
        'is_pinned' => 'boolean',
        'tags' => 'array',
        'dipublikasikan_pada' => 'datetime',
    ];

    // =====================================================================
    // ACTIVITY LOG
    // =====================================================================

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['judul', 'status', 'is_pinned', 'kategori'])
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn (string $eventName) => "Pengumuman \"{$this->judul}\" di-{$eventName}");
    }

    // =====================================================================
    // RELASI
    // =====================================================================

    public function organisasi()
    {
        return $this->belongsTo(Organisasi::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // =====================================================================
    // SCOPES
    // =====================================================================

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopePinned($query)
    {
        return $query->where('is_pinned', true);
    }

    public function scopeDPM($query)
    {
        return $query->whereNull('organisasi_id');
    }

    public function scopeTerbaru($query)
    {
        return $query->orderByDesc('dipublikasikan_pada');
    }
}
