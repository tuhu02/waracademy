<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProgresLevelUser extends Model
{
    use HasFactory;

    protected $table = 'progreslevelpengguna';
    protected $primaryKey = 'id_progres';
    public $timestamps = false;

    protected $fillable = ['id_pengguna','id_level','exp','bintang'];

    public function level()
    {
        return $this->belongsTo(Level::class, 'id_level', 'id_level');
    }
}