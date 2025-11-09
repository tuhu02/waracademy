<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    protected $table = 'level';
    protected $primaryKey = 'id_level';
    public $timestamps = false;

    public function KisiKisi() {
        return $this->hasMany(KisiKisi::class, 'id_level', 'id_level');
    }


}