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

    protected $fillable = ['id_turnamen','id_pengguna','skor_akhir','peringkat'];

    public function turnamen()
    {
        return $this->belongsTo(Turnamen::class, 'id_turnamen', 'id_turnamen');
    }
}
