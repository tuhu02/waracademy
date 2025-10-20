<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    protected $table = 'level';
    protected $primaryKey = 'id_level';
    public $timestamps = false;

    public function kisiKisi()
    {
        return $this->hasOne(KisiKisi::class, 'level_id', 'id_level');
    }

}