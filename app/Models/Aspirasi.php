<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aspirasi extends Model
{
    // Mendefinisikan nama tabel
    protected $table = 'aspirasi';

    // Menginisiasi column yang dapat diisi
    protected $fillable = [
        'siswa_id',
        'judul',
        'lokasi',
        'keterangan',
    ];

    // Relasi many to one dengan tabel siswa
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    // Relasi one to many dengan tabel umpan_balik
    public function umpanBalik()
    {
        return $this->hasMany(UmpanBalik::class);
    }
}
