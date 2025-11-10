<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesertaTurnamen extends Model
{
    use HasFactory;

    protected $table = 'pesertaturnamen';
    protected $primaryKey = 'id_peserta';
    public $timestamps = false;

    protected $fillable = [
        'id_turnamen',
        'id_pengguna',
        'skor_akhir',
        'peringkat',
        'joined_at',
        'status',
        'lives_remaining',
    ];
}
