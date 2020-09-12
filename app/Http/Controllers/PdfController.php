<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Time;
use DB;
use PDF;
use View;
use App\Student;
class PdfController extends Controller
{
    public function class_bill_pdf(){
        //return 1;
        $time=Time::all();
        $class_name=request()->class_name;
        if(strpos($class_name, "碩")){
            $degree="碩士";
            $cloth_pick_time=$time->where('content','領取時間(碩士服)')->first();
        }
        else{
            $degree="學士";
            $cloth_pick_time=$time->where('content','領取時間(學士服)')->first();
        }
        $bill_pdf=View::make('partial_view.bill',[
            'class_name'=>request()->class_name,
            'order_number'=>DB::table('student_order')->select(DB::raw('count(class_name) as total'))->where('class_name',request()->class_name)->first(),
            'payment_time'=>$time->where('content','繳費期限')->first(),
            'cloth_pick_time'=>$cloth_pick_time,
            'bill_receipt'=>['出納','繳款人','事務整備組'],
            'degree'=>$degree,
        ]);
        $html = $bill_pdf->render();
        //return $html;
        $pdf = PDF::loadHTML($html);
        return $pdf->stream('學士服繳費單.pdf');
    }
    public function not_return(){
        $not_return_order = DB::table('student_order')->select(DB::raw('*'))->where('state',0)->get();   
        $not_return_pdf=View::make('partial_view.record_order_table',[
            'pdf_name'=>"未歸還名單",
            'return_order_state'=>$not_return_order,
        ]);   
        $html = $not_return_pdf->render();
        $pdf = PDF::loadHTML($html);
        return $pdf->stream('未歸還名單.pdf');

    }
    public function is_return(){
        $is_return_order = DB::table('student_order')->select(DB::raw('*'))->where('state',1)->get();   
        $is_return_pdf=View::make('partial_view.record_order_table',[
            'pdf_name'=>"已歸還名冊",
            'return_order_state'=>$is_return_order,
        ]);   
        $html = $is_return_pdf->render();
        $pdf = PDF::loadHTML($html);
        return $pdf->stream('已歸還名冊.pdf');
    }
}
