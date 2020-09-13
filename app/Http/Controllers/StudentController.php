<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Order;
use App\Cloth;
class StudentController extends Controller
{
    public function __construct(){
        $this->middleware('preventBackHistory'); 
        $this->middleware('auth:student');
    }
    public function index(){
        return view('index',
        [
            'user'=>Auth::guard('student')->user(),
            'order'=>Order::where('stu_id',Auth::guard('student')->user()->student_id)->get(),
            'cloth_config'=>Cloth::where('type',Auth::guard('student')->user()->m_or_b)->get(),
        ]);
    }
}
