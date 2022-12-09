<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SocialLinks extends Model
{
    protected $fillable=[
        'link',
        'created_at',
        'updated_at'
    ];
}
