<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rekomendasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'data_siswa_id',
        'beasiswa_id',
        'guru_bk_id',
        'persentase_kecocokan',
        'status',
        'catatan',
        'direkomendasikan_oleh',
        'dipilih_siswa',
        'dipilih_at',
    ];
    protected $casts = [
        'dipilih_at' => 'datetime',
        'dipilih_siswa' => 'boolean',
    ];
    /**
     * Scope for recommendations chosen by students.
     */
    public function scopeDipilihSiswa($query)
    {
        return $query->where('dipilih_siswa', true);
    }

    /**
     * Scope for recommendations made by Admin.
     */
    public function scopeByAdmin($query)
    {
        return $query->where('direkomendasikan_oleh', 'admin');
    }

    /**
     * Scope for recommendations made by Guru BK.
     */
    public function scopeByGuruBK($query)
    {
        return $query->where('direkomendasikan_oleh', 'guru_bk');
    }

    /**
     * Check if a student has already selected a recommendation.
     */
    public static function sudahMemilih($siswaId)
    {
        $dataSiswaId = DataSiswa::where('user_id', $siswaId)->value('id') ?? $siswaId;
        return self::where('data_siswa_id', $dataSiswaId)
            ->where('dipilih_siswa', true)
            ->exists();
    }

    /**
     * Get the student profile that receives this recommendation.
     */
    public function dataSiswa(): BelongsTo
    {
        return $this->belongsTo(DataSiswa::class, 'data_siswa_id');
    }

    /**
     * Get the scholarship recommended.
     */
    public function beasiswa(): BelongsTo
    {
        return $this->belongsTo(Beasiswa::class, 'beasiswa_id');
    }

    /**
     * Get the BK teacher who authored the recommendation.
     */
    public function guruBk(): BelongsTo
    {
        return $this->belongsTo(User::class, 'guru_bk_id');
    }
}
