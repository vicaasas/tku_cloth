<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Order;
use App\Cloth;

class ReturnClothController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.return');
    }

    public function post(){
        return view('admin.return',
        [
            'this_student_order'=>DB::table('student_order')->select(DB::raw('*'))
                            ->where('student_id',request()->stu_id)
                            ->get(),
        ]);
    }
    public function edit_order(){

        //return request()->type;
        //$order_type=Cloth::where('type',request()->type);
        return 1;
        //try{
            $cloth_index=Cloth::where('type',request()->type)->where('property', '=', request()->size)->first()->id;
            $accessory_index=Cloth::where('type',request()->type)->where('property', '=', request()->color)->first()->id;
            
            Order::where('stu_id', request()->student_id)
            ->update(
                [
                    'cloth' => $cloth_index,
                    'accessory' => $accessory_index,
                ],
            );
            return 1;
        // }
        // catch (\Illuminate\Database\QueryException $ex){
        //     dd($ex->getMessage()); 
        // }
       
        
        return view('admin.report.student_list',
        [
            "all_student_order" => DB::table('student_order')->select(DB::raw('*'))->get(),
        ]);
        //return DB::table('student_order')->select(DB::raw('*'))->get();

    }
    public function return_cloth(){
        $select_column_data=request()->select_column_data;
        //return gettype($test);
        return 1;
        foreach($select_column_data as $key => $value){
            Order::where('stu_id', $select_column_data[$key])->update(['state' => 1]);
        }
        //return DB::table('student_order')->select(DB::raw('*'))->get();

    }
    public function delete_order(){
        $select_column_data=request()->select_column_data;
        //return gettype($test);
        return 1;
        foreach($select_column_data as $key => $value){
            Order::where('stu_id', $select_column_data[$key])->delete();
        }
        //return DB::table('student_order')->select(DB::raw('*'))->get();
    }
}
