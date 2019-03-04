<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commodity_Img extends Model
{
    protected $table = 'commodity_img';

    protected $fillable = [
        'commodity_list_id', 'img'
    ];

    public $timestamps = true;

    public function Imgs()
    {	
       return $this->belongsTo('App\Commodity_List','commodity_list_id','id');
    }
}
