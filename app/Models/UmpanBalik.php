<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UmpanBalik extends Model
{
    // Mendefinisikan nama tabel
    protected $table = 'umpan_balik';

    // Menginisiasi column yang dapat diisi
    protected $fillable = [
        'user_id',
        'aspirasi_id',
        'isi_umpan_balik',
        'status_penyelesaian',
    ];

    // Relasi many to one dengan tabel users
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi many to one dengan tabel aspirasi
    public function aspirasi()
    {
        return $this->belongsTo(Aspirasi::class);
    }
}
