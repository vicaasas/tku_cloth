<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Student;
use App\StudentHaveOrders;
use App\Order;
use App\Cloth;
use View;
class ReturnClothController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.return');
    }
    public function return_table($index)
    {
        
        $table=View::make('partial_view.return_table',[
            'student_order'=>DB::table('student_order')->where('student_id',$index)->where('has_paid',1)->where('has_get_cloths',1)->where('return',0)->get(),
        ]);
        $return_table=$table->render();
        return 
        [
            'return_table'=> $return_table,
        ];

    }
    public function get_student_order(){
        
        return view('admin.return',self::return_table(request()->stu_id));
    }
    public function self_cloth(){
        
        $order_id=request()->order_id;
        $student_id=request()->student_id;
        //return 1;
        Order::where('order_id', $order_id)->where('stu_id', $student_id)->update(['return' => 1]);
        return request()->order_id;
        //return DB::table('student_order')->select(DB::raw('*'))->get();

    }
    public function edit_order(){

        //return request()->type;
        //$order_type=Cloth::where('type',request()->type);
        //return 1;
        //try{

            $type=Student::where('student_id',request()->student_id)->first()->m_or_b;
            $cloth_index=Cloth::where('type',$type)->where('property', '=', request()->size)->first()->id;
            $accessory_index=Cloth::where('type',$type)->where('property', '=', request()->color)->first()->id;
            
            Order::where('stu_id', request()->student_id)
            ->update(
                [
                    'cloth' => $cloth_index,
                    'accessory' => $accessory_index,
                ],
            );
            return redirect()->back()->with('success', '訂單編輯成功');

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
            Order::where('stu_id', $select_column_data[$key])->update(['return' => 1]);
        }
        //return DB::table('student_order')->select(DB::raw('*'))->get();

    }
    public function delete_order(){
        //$select_column_data=request()->select_column_data;
        //return gettype($test);
        //return 1;
        Order::where('order_id',request()->order_id)->where('stu_id', request()->student_id)->update(['has_cancel' => 1]);
        // if(Order::where('order_id',request()->order_id)->first()==null){
        //     StudentHaveOrders::where('order_id',request()->order_id)->delete();
        // }
        // foreach($select_column_data as $key => $value){
            
        // }
        return 1;

        //return DB::table('student_order')->select(DB::raw('*'))->get();
    }
}
