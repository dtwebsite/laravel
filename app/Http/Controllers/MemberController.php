<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class MemberController extends Controller
{
    public function index()
    {
        return view('admin.member_list');
    }

    public function get_member_list()
    {
        $data = DB::table('users')->paginate(10);
        return response()->json($data);
    }

    public function member_delete(Request $request)
    {
    	DB::table('users')->where('id',$request->id)->delete();
    }

    public function member_edit(Request $request)
    {
    	$data = DB::table('users')->where('id',$request->id)->update(['name' => $request->name,'email' => $request->email]);
    	return response()->json($data);
    }
}
