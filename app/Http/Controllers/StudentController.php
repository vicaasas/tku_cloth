<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
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
        ]);
    }
}
