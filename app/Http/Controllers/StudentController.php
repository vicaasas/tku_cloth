<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Order;
use App\Cloth;
use App\Student;
use App\StudentHaveOrders;
use DB;
class StudentController extends Controller
{
    public function __construct(){
        $this->middleware('preventBackHistory'); 
        $this->middleware('auth:student');
    }
    public function index(){
        //return csrf_token();
        return view('index',
        [
            'user'=>Auth::guard('student')->user(),
            'student_class_data'=>Student::where('class_name',Auth::guard('student')->user()->class_name)->get(),
            'student_order'=>StudentHaveOrders::where('stu_id',Auth::guard('student')->user()->student_id)->with('have_orders')->get(),
            'cloth_remainder'=>DB::table('cloths')->leftJoin('orders',function($l_join){
                                $l_join->on('orders.cloth','=','cloths.id')->orOn('orders.accessory','=','cloths.id');
                            })->select(DB::raw('cloths.type,cloths.name,cloths.property,(cloths.quantity-count(orders.id)) as remainder'))
                            ->groupby('cloths.id')
                            ->where('cloths.type','=',Auth::guard('student')->user()->m_or_b)
                            ->get(),
        ]);
    }
}
