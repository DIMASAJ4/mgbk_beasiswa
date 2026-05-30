<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Beasiswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'kampus_mitra_id',
        'nama_beasiswa',
        'deskripsi',
        'jenis',
        'persyaratan',
        'kuota',
        'deadline',
        'status',
        'thumbnail',
    ];

    protected $casts = [
        'persyaratan' => 'json',
        'deadline' => 'date',
    ];

    /**
     * Get the campus that owns the scholarship.
     */
    public function kampusMitra(): BelongsTo
    {
        return $this->belongsTo(KampusMitra::class, 'kampus_mitra_id');
    }

    /**
     * Get the recommendations for the scholarship.
     */
    public function rekomendasis(): HasMany
    {
        return $this->hasMany(Rekomendasi::class);
    }
}
