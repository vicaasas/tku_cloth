<?php

namespace App\Http\Controllers;
use App\Student;
use Illuminate\Http\Request;
use View;
use PDF;
use DB;
use App\Time;
use Auth;
class BillController extends Controller
{
    public function bill(){
        return view('admin.report.bill',
        [
            'class_name'=>Student::select(Student::raw('class_name'))->groupBy('class_name')->get(),
        ]);
    }
    public function class_bill(){
        return view('admin.report.class_bill',
        [
            'class_name'=>request()->class_name,
        ]);
    }
    public function __construct(){
        $this->middleware('auth'); 
        $this->middleware('preventBackHistory'); 
        
    }
}
