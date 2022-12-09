<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class footer_info extends Model
{
    protected $fillable=[
        'column_name',
        'title',
        'details'
    ];

    public $table="footer_info";
}
