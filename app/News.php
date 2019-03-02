<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = 'news';

    protected $fillable = [
        'id','title', 'content', 'status'
    ];

    public $timestamps = true;
}
