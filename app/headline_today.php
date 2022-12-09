<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class headline_today extends Model
{
    public $table="headline_today";

    protected $fillable=[
        'id',
        'news_id'
    ];
}
