<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use App\Commodity_Category;
use App\Commodity_List;
use App\Commodity_Img;
use DB;

class CommodityController extends Controller
{
    public function category_index()
    {
        return view('admin.commodity_category');
    }

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

    public function list_index()
    {
        return view('admin.commodity_list');
    }

    public function get_commodity_list()
    {
    	$category = DB::table('commodity_category')->where('level', 1)->get();
    	foreach ($category as $cat) {
    		$list[$cat->id][0]['category'] = $cat;
    	}
        $data = Commodity_List::with('Category')->get();
        $imgs = Commodity_Img::with('Imgs')->get();
        foreach ($data as $key => $value) {
            $list[$value['category']['id']][$value['id']] = $value;
            $list[$value['category']['id']][$value['id']]['img'] = [];
            $tmp_img = [];
            foreach ($imgs as $k => $v) {
                if($v['commodity_list_id'] == $value['id']){
                    $tmp_img[] = $v['img'];
                }
                $list[$value['category']['id']][$value['id']]['img'] = $tmp_img;
            }
        }
        return response()->json($list);
    }

    public function insert_commodity(Request $request)
    {
        $input = $request->all();
        $commodity_list = new Commodity_List($input);
        $commodity_list->save();
        foreach ($input['img'] as $key => $value) {
            $extension = '.'.$value->getClientOriginalExtension();
            $ver = time().rand(11111,99999);
            $file_name = $ver.$extension;
            $file_path = 'images/commodity_images/'.$file_name;
            $img = Image::make($value->getRealPath())->save($file_path);
            $img_data = [
                'img' => $file_path,
            ];
            $commodity_img = new Commodity_Img($img_data);
            $commodity_list->List_img()->save($commodity_img);
        }
        $return = [
            'in' => 'success',
            'message' => '新增成功！',
        ];
        return response()->json($return);
    }

    public function commodity_delete(Request $request)
    {
        $commodity_delete = Commodity_List::findOrFail($request->id);
        $commodity_delete->delete();
        $commodity_delete->List_img()->delete();
    }

    public function get_commodity_edit_data(Request $request)
    {
        $data['data'] = DB::table('commodity_list')->where('id',$request->id)->first();
        $data['img'] = DB::table('commodity_img')->where('commodity_list_id',$request->id)->get();
        return response()->json($data);
    }

    public function delete_images(Request $request)
    {
        $delete_images = Commodity_Img::findOrFail($request->id);
        $delete_images->delete();
    }

    public function edit_commodity(Request $request)
    {
        $edit_data = $request->all();
        $commodity_list = Commodity_List::find($request->id)->fill($edit_data);
        $commodity_list->save();
        foreach ($edit_data['img'] as $key => $value) {
            $extension = '.'.$value->getClientOriginalExtension();
            $ver = time().rand(11111,99999);
            $file_name = $ver.$extension;
            $file_path = 'images/commodity_images/'.$file_name;
            $img = Image::make($value->getRealPath())->save($file_path);
            $img_data = [
                'img' => $file_path,
            ];
            $commodity_img = new Commodity_Img($img_data);
            $commodity_list->List_img()->save($commodity_img);
        }
        $return = [
            'in' => 'success',
            'message' => '修改成功！',
        ];
        return response()->json($return);
    }
}
