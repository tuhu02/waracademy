<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TurnamenPilihanJawaban extends Model
{
    use HasFactory;

    protected $table = 'turnamen_pilihan_jawaban';
    protected $primaryKey = 'id_jawaban';
    public $timestamps = false;

    protected $fillable = [
        'id_pertanyaan_turnamen',
        'teks_jawaban',
        'adalah_benar',
    ];
}
