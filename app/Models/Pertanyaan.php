<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pertanyaan extends Model
{
    use HasFactory;

    protected $table = 'pertanyaan';
    protected $primaryKey = 'id_pertanyaan';
    public $timestamps = false;

    protected $fillable = [
        'id_level',
        'teks_pertanyaan',
        'gambar',
    ];

    // relasi: satu pertanyaan punya banyak pilihan jawaban
    public function pilihanjawaban()
    {
        return $this->hasMany(Pilihanjawaban::class, 'id_pertanyaan', 'id_pertanyaan');
    }
}
