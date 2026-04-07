<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    // Mendefinisikan nama tabel
    protected $table = 'siswa';

    // Menginisiasi column yang dapat diisi
    protected $fillable = [
        'user_id',
        'nis',
        'kelas',
    ];

    // Relasi one to one dengan tabel users
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi one to many dengan tabel aspirasi
    public function aspirasi()
    {
        return $this->hasMany(Aspirasi::class);
    }
}
