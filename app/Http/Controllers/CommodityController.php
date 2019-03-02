<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Commodity_Category;
use DB;

class CommodityController extends Controller
{
	public function get_commodity_category()
    {
        $data = DB::table('commodity_category')->orderBy('level', 'asc')->get();
        $category = [];
        foreach ($data as $key => $value) {
        	if($value->level == 0 && $value->up_id == 0){
        		$category[$value->id]['id'] = $value->id;
        		$category[$value->id]['title'] = $value->title;
        	}else{
        		if(isset($category[$value->up_id])){
        			$category[$value->up_id]['sub_items'][] = [
        				'id' => $value->id,
        				'title' => $value->title,
        			];
        		}
        	}
        }
        return response()->json($category);
    }

    public function insert_commodity_category(Request $request)
    {
        $input = $request->all();
        $commodity_category = new Commodity_Category($input);
        $commodity_category->save();
    }

    public function edit_commodity_category(Request $request)
    {
        $edit_data = $request->all();
        $commodity_category = Commodity_Category::find($request->id)->fill($edit_data);
        $commodity_category->save();
    }

    public function commodity_category_delete(Request $request)
    {
        $commodity_category_delete = Commodity_Category::findOrFail($request->id);
        $commodity_category_delete->delete();
    }
}
