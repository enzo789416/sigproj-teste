<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Poll extends Model
{
    protected $table = "polls";
    protected $fillable = [
        'titulo', 'data_inicio','data_fim'
    ];
}
