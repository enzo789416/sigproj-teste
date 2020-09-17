<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Poll extends Model
{
    use SoftDeletes;
    protected $table = "polls";
    protected $fillable = [
        'titulo', 'data_inicio','data_fim'
    ];
}
