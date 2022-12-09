<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HomepageVisitor extends Model
{
    protected  $fillable=[
        'hit_time',
        'exit_time'
    ];

    public $timestamps=true;
}
