<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TurnamenPertanyaan extends Model
{
    use HasFactory;

    protected $table = 'turnamen_pertanyaan';
    protected $primaryKey = 'id';
    public $timestamps = false; // created_at present but keep false to avoid conflicts

    protected $fillable = [
        'id_turnamen',
        'teks_pertanyaan',
        'poin_per_soal',
        'waktu_pengerjaan',
        'tingkat_kesulitan',
        'mata_pelajaran',
        'created_at',
    ];
    public function jawaban()
    {
        return $this->hasMany(TurnamenPilihanJawaban::class, 'id_pertanyaan_turnamen');
    }
}
