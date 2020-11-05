<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Order;
use App\Cloth;
use App\Student;
use App\GetClothTime;
use App\StudentHaveOrders;
use App\ViewOrder;
use DB;
class StudentController extends Controller
{
    public function __construct(){
        $this->middleware('preventBackHistory'); 
        $this->middleware('auth:student');
    }
    public function index(){
        //return substr($student_data->class_id,0,5);
        
        $student_data=Auth::guard('student')->user();
        //return StudentHaveOrders::where('stu_id',$student_data->student_id)->with('have_orders')->first();
        
        $agent_order=StudentHaveOrders::where('stu_id',$student_data->student_id)->with('have_orders')->get();
        $student_order=ViewOrder::where('student_id',$student_data->student_id)->first();


        return view('index',
        [
            'user'=>$student_data,
            'self_order'=>$student_order,
            'agent_order'=>$agent_order,
            'cancel_order'=>StudentHaveOrders::where('stu_id',$student_data->student_id)->with('this_cancels')->get(),
            'class_data'=>Student::where('class_id','like',substr($student_data->class_id,0,5).'%')->get(),
            'get_cloths_time'=>GetClothTime::where("degree",$student_data->m_or_b)->get(),
            'cloth_remainder'=>DB::table('cloths')->leftJoin('orders',function($l_join){
                                $l_join->on('orders.cloth','=','cloths.id')->orOn('orders.accessory','=','cloths.id')->where('orders.has_cancel',0);
                            })->select(DB::raw('cloths.type,cloths.name,cloths.property,(cloths.quantity-count(orders.id)) as remainder'))
                            ->groupby('cloths.id')
                            ->where('cloths.type','=',$student_data->m_or_b)
                            ->get(),
        ]);
    }
}
