<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengguna extends Model
{
    use HasFactory;

    protected $table = 'pengguna';
    protected $primaryKey = 'id_pengguna';
    public $timestamps = false; // tabel menggunakan created_at manual/ berbeda

    protected $fillable = [
        'username', 'email', 'role', 'password_hash', 'google_id', 'total_exp', 'deskripsi_profil', 'avatar_url'
    ];

    public function progres()
    {
        return $this->hasMany(ProgresLevelUser::class, 'id_pengguna', 'id_pengguna');
    }

    public function riwayatPertandingan()
    {
        return $this->hasMany(RiwayatPertandingan::class, 'id_pengguna', 'id_pengguna');
    }

    public function pesertaTurnamen()
    {
        return $this->hasMany(PesertaTurnamen::class, 'id_pengguna', 'id_pengguna');
    }
}

