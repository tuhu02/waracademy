<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pengguna extends Authenticatable
{
    use Notifiable;

    protected $table = 'pengguna';
    protected $primaryKey = 'id_pengguna';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false; // tabel Anda menggunakan tanggal_registrasi custom

    protected $fillable = [
        'username',
        'email',
        'role',
        'password_hash',
        'google_id',
        'total_exp',
        'deskripsi_profil',
        'avatar_url',
        'tanggal_registrasi'
    ];

    protected $hidden = [
        'password_hash'
    ];

    // Laravel Authentication akan mengambil password melalui method ini
    public function getAuthPassword()
    {
        return $this->password_hash;
    }
}
