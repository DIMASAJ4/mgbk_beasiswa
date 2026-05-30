<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DataSiswa extends Model
{
    use HasFactory;

    protected $table = 'data_siswas';

    protected $fillable = [
        'user_id',
        'nilai_rata',
        'prestasi',
        'kondisi_ekonomi',
        'minat_jurusan',
        'is_verified',
    ];

    protected $casts = [
        'nilai_rata' => 'decimal:2',
        'minat_jurusan' => 'json',
        'is_verified' => 'boolean',
    ];

    /**
     * Get the user that owns the student profile data.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the recommendations for this student.
     */
    public function rekomendasis(): HasMany
    {
        return $this->hasMany(Rekomendasi::class);
    }
}
