<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class menu_items extends Model
{
    protected $fillable=[
        'menu',
        'sub_menu',
        'id'
    ];
}
