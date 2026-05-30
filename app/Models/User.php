<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the student profile data if the user is a student.
     */
    public function dataSiswa(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(DataSiswa::class, 'user_id');
    }

    /**
     * Get the recommendations authored by this BK teacher.
     */
    public function rekomendasis(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Rekomendasi::class, 'guru_bk_id');
    }
}
