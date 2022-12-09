<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable=[
        'headline',
        'headline_image',
        'news_category',
        'body',
        'hit',
        'published_by',
        'published_at'
    ];

    public $timestamps=true;
}
