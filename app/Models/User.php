<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    // Menginisiasi column yang dapat diisi
    protected $fillable = [
        'nama',
        'email',
        'password',
        'is_siswa',
    ];

    // Relasi one to one dengan tabel siswa
    public function siswa()
    {
        return $this->hasOne(Siswa::class);
    }
    // Relasi one to many dengan tabel umpan_balik
    public function umpanBalik()
    {
        return $this->hasMany(UmpanBalik::class);
    }

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
            'is_siswa' => 'boolean',
        ];
    }
}
