<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    use HasFactory;

    protected $table = 'tournaments';

    protected $fillable = [
        'name',
        'date',
        'duration',
        'max_participants',
        'description',
        'point_per_question',
        'bonus_exp',
        'room_code',
        'questions',
        'created_by'
    ];

    protected $casts = [
        'questions' => 'array',
        'date' => 'datetime',
    ];
}
