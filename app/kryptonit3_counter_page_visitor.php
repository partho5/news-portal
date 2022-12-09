<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class kryptonit3_counter_page_visitor extends Model
{
    protected $fillable=[
        'page_id',
        'visitor_id',
        'created_at'
    ];

    public $table='kryptonit3_counter_page_visitor';
}
