<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\News;
use DB;

class NewsController extends Controller
{
    public function index()
    {
        return view('admin.news_list');
    }
    
    public function get_news_list()
    {
        $data = DB::table('news')->paginate(5);
        return response()->json($data);
    }

    public function insert_news(Request $request)
    {
        $input = $request->all();
        $news = new News($input);
        $news->save();
    }

    public function get_edit_data(Request $request)
    {
        $data = DB::table('news')->where('id',$request->id)->first();
        return response()->json($data);
    }

    public function news_edit(Request $request)
    {
        $edit_data = $request->all();
        $news_edit = News::find($request->id)->fill($edit_data);
        $news_edit->save();
    }

    public function news_delete(Request $request)
    {
        $news_delete = News::findOrFail($request->id);
        $news_delete->delete();
    }
}
