<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPertandingan extends Model
{
    use HasFactory;

    protected $table = 'riwayatpertandingan';
    protected $primaryKey = 'id_pertandingan';
    public $timestamps = false;

    protected $fillable = [
        'id_pengguna', 'id_level', 'id_turnamen',
        'exp_didapat', 'bintang_didapat', 'waktu_selesai'
    ];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id_pengguna');
    }

    public function level()
    {
        return $this->belongsTo(Level::class, 'id_level', 'id_level');
    }

    public function turnamen()
    {
        return $this->belongsTo(Turnamen::class, 'id_turnamen', 'id_turnamen');
    }
}
