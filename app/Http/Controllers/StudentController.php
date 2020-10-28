<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Order;
use App\Cloth;
use App\Student;
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
        $order_time=StudentHaveOrders::where('stu_id',$student_data->student_id)->where('has_paid',1)->get();
        //return (strtotime(date('Y/m/d h:i:s'))-strtotime($order_time->created_at))/86400;
        foreach($order_time as $order_time){
            if((strtotime(date('Y/m/d h:i:s'))-strtotime($order_time->created_at))/86400>=3){
                Order::where('order_id',$order_time->order_id)->update(['has_cancel'=>1]);
            }
        }
        $order_data=StudentHaveOrders::where('stu_id',$student_data->student_id)->with('have_orders')->get();
        $student_order_data=ViewOrder::where('student_id',$student_data->student_id)->where('has_cancel',0)->first();
        $student_cancel_order_data=ViewOrder::where('student_id',$student_data->student_id)->where('has_cancel',1)->first();
        // if($order_data->first() != null&&$student_order_data!=null){
        //     $agent=$order_data;
        //     $self_order=null;
        // }
        // else{
            if($order_data->first() != null){
                $agent=$order_data;
            }
            else{
                $agent=null;
            }
            if($student_order_data!=null){
                $my_order_id=ViewOrder::where('student_id',$student_data->student_id)->first()->order_id;
                $self_order=StudentHaveOrders::where('order_id',$my_order_id)->with('have_orders')->first();
            }
            else if($student_cancel_order_data!=null){
                $my_order_id=ViewOrder::where('student_id',$student_data->student_id)->first()->order_id;
                $self_order=StudentHaveOrders::where('order_id',$my_order_id)->with('this_cancels')->first();
            }
            else{
                $self_order=null;
                
            }
        //}

        return view('index',
        [
            'user'=>$student_data,
            'cancel_order'=>StudentHaveOrders::where('stu_id',$student_data->student_id)->with('this_cancels')->get(),
            'self_order'=>$self_order,
            'student_class_data'=>Student::where('class_id','like',substr($student_data->class_id,0,5).'%')->get(),
            'student_order'=>$agent,
            'cloth_remainder'=>DB::table('cloths')->leftJoin('orders',function($l_join){
                                $l_join->on('orders.cloth','=','cloths.id')->orOn('orders.accessory','=','cloths.id')->where('orders.has_cancel',0);
                            })->select(DB::raw('cloths.type,cloths.name,cloths.property,(cloths.quantity-count(orders.id)) as remainder'))
                            ->groupby('cloths.id')
                            ->where('cloths.type','=',$student_data->m_or_b)
                            ->get(),
        ]);
    }
}
