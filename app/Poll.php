<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    protected $table = "polls";
    protected $fillable = [
        'titulo', 'data_inicio', 'data_fim'
    ];
}
