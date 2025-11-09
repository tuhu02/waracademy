<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turnamen extends Model
{
    use HasFactory;

    protected $table = 'turnamen';
    protected $primaryKey = 'id_turnamen';
    public $incrementing = true;
    public $timestamps = true; // DB dump includes created_at/updated_at

    protected $fillable = [
        'nama_turnamen',
        'kode_room',
        'dibuat_oleh',
        'level_minimal',
        'status',
        'tanggal_pelaksanaan',
        'durasi_pengerjaan',
        'max_peserta',
        'deskripsi',
        'bonus_exp',
    ];
}
