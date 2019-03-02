<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commodity_Category extends Model
{
    protected $table = 'commodity_category';

    protected $fillable = [
        'id','title', 'level', 'up_id'
    ];

    public $timestamps = true;
}
