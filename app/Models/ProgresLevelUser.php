<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgresLevelUser extends Model
{
    protected $table = 'progreslevelpengguna'; // pastikan nama table sesuai
    protected $primaryKey = 'id_progres';      // primary key table
    public $timestamps = false;                // kalau tidak ada created_at/updated_at

    protected $fillable = ['id_pengguna', 'id_level', 'exp', 'bintang'];
}
