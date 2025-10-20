<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KisiKisi extends Model
{
    use HasFactory;

    protected $table = 'kisi_kisi';
    protected $primaryKey = 'id_kisi';
    public $timestamps = false;

    protected $fillable = [
        'level_id', 'topik', 'jumlah_soal', 'waktu_menit', 'jenis_soal'
    ];

    public function level()
    {
        return $this->belongsTo(Level::class, 'level_id', 'id_level');
    }
}