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
    public function __construct(){
        $this->middleware('preventBackHistory'); 
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        return view('admin.function_page.return');
    }

    public function get_student_order(){
        $table=View::make('partial_view.return_table',[
            'student_order'=>DB::table('student_order')->where('student_id',$index)->where('has_paid',1)->where('has_get_cloths',1)->where('return',0)->get(),
        ]);
        $return_table=$table->render();

        return view('admin.return',[
            'return_table'=> $return_table,
        ]);
    }
    public function self_cloth(){
        
        $order_id=request()->order_id;
        $student_id=request()->student_id;
        //return 1;
        Order::where('order_id', $order_id)->where('stu_id', $student_id)->update(['return' => 1]);
        return request()->order_id;
        //return DB::table('student_order')->select(DB::raw('*'))->get();

    }

    public function get_refund_order(){
        $index=request()->get_id;
        $student_order=StudentHaveOrders::where('stu_id',$index)->where('has_get_cloths',0)->where('has_paid',1)->first();
        if($student_order!=null){
            $table=View::make('partial_view.refund_order',[
                'student_order'=>StudentHaveOrders::where('stu_id',$index)->where('has_get_cloths',0)->where('has_paid',1)->with('have_orders')->with('get_counts')->get(),

            ]);
            $student_table=$table->render();

        }
        else{
            $table=View::make('partial_view.refund_order',[
                'student_order'=>StudentHaveOrders::where('order_id',$index)->where('has_get_cloths',0)->where('has_paid',1)->where('has_paid',1)->with('have_orders')->get(),
            ]);
            $student_table=$table->render();

        }

        return view('admin.function_page.refund_view',[
            'student_table'=> $student_table,
        ]);

        //return DB::table('student_order')->select(DB::raw('*'))->get();
    }
    public function determine_refund(){
        Order::where('order_id',request()->order_id)->update(['has_cancel' => 1]);
        //StudentHaveOrders::where('order_id',request()->order_id)->where('has_get_cloths',0)->where('has_paid',1)->delete();

        return 1;


    }
}
