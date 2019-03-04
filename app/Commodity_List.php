<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commodity_List extends Model
{
    protected $table = 'commodity_list';

    protected $fillable = [
        'category_id', 'name', 'price', 'description', 'remark', 'status'
    ];

    public $timestamps = true;

    public function Category()
    {	
       return $this->belongsTo('App\Commodity_Category','category_id','id');
    }

    public function List_img()
    {
    	return $this->hasMany('App\Commodity_Img','commodity_list_id','id');
    }
}
