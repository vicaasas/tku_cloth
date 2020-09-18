<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Time;
use DB;
use PDF;
use View;
use Auth;
use App\Student;
use App\StudentHaveOrders;
class PdfController extends Controller
{
    public function student_bill_pdf(){
        $time=Time::all();
        $student_id=request()->student_id;
        $student_data=Student::where('student_id',$student_id)->first();
       
        if($student_data->m_or_b=="碩士"){
            $cloth_pick_time=$time->where('content','領取時間(碩士服)')->first();
        }
        else{
            $cloth_pick_time=$time->where('content','領取時間(學士服)')->first();
        }
        $bill_pdf=View::make('partial_view.bill',[
            'student_data'=>$student_data,
            'student_order'=>StudentHaveOrders::where('stu_id',$student_id)->with('have_orders')->get(),
            'payment_time'=>$time->where('content','繳費期限')->first(),
            'cloth_pick_time'=>$cloth_pick_time,
            'bill_receipt'=>['繳費收據(事務整備組)','繳款人收據'],
        ]);

        // $bill_pdf=View::make('partial_view.bill',[
        //     'student_id'=>request()->student_id,
        //     'order_number'=>DB::table('student_order')->select(DB::raw('count(class_name) as total'))->where('class_name',request()->class_name)->first(),
        //     'payment_time'=>$time->where('content','繳費期限')->first(),
        //     'cloth_pick_time'=>$cloth_pick_time,
        //     'bill_receipt'=>['出納','繳款人','事務整備組'],
        //     'degree'=>$degree,
        // ]);
        $html = $bill_pdf->render();
        //return $html;
        $pdf = PDF::loadHTML($html);
        return $pdf->stream('學士服繳費單.pdf');
    }
    public function not_return(){
        $not_return_order = DB::table('student_order')->select(DB::raw('*'))->where('return',0)->where('has_get_cloths',1)->get();   
        $not_return_pdf=View::make('partial_view.record_order_table',[
            'pdf_name'=>"未歸還名單",
            'return_order_state'=>$not_return_order,
        ]);   
        $html = $not_return_pdf->render();
        $pdf = PDF::loadHTML($html);
        return $pdf->stream('未歸還名單.pdf');

    }
    public function is_return(){
        $is_return_order = DB::table('student_order')->select(DB::raw('*'))->where('return',1)->get();   
        $is_return_pdf=View::make('partial_view.record_order_table',[
            'pdf_name'=>"已歸還名冊",
            'return_order_state'=>$is_return_order,
        ]);   
        $html = (string)$is_return_pdf;

        $pdf = PDF::loadHTML($html);
        return $pdf->stream('已歸還名冊.pdf');
    }
    public function receipt_bail(){
        $is_return_order = DB::table('student_order')->select(DB::raw('*'))->where('has_paid',1)->where('has_get_cloths',1)->get();   
        $is_return_pdf=View::make('partial_view.receipt_bail',[
            'student_data'=>Auth::guard('student')->user(),
            'year'=>(date("Y") - 1911),
            'month'=>date("m"),
            'day'=>date("d"),
        ]);   
        $html = (string)$is_return_pdf;
        //return $html;
        //
        $pdf = PDF::loadHtml($html)->setPaper('a5', 'landscape');
        
        return $pdf->stream('已歸還名冊.pdf');
    }
    public function exportCsv()
    {
        $fileName = 'tasks.csv';
        $tasks = DB::table('student_order')->where('has_paid',1)->get();
     
             $headers = array(
                 "Content-type"        => "text/csv",
                 "Content-Disposition" => "attachment; filename=$fileName",
                 "Pragma"              => "no-cache",
                 "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                 "Expires"             => "0"
             );
     
             $columns = array('class_name', 'student_id', 'student_name', 'degree', 'size','color');
     
             $callback = function() use($tasks, $columns) {
                 $file = fopen('php://output', 'w');
                 fwrite($file, chr(0xEF).chr(0xBB).chr(0xBF));
                 fputcsv($file, $columns);
     
                 foreach ($tasks as $task) {
                     $row['class_name']  = $task->class_name;
                     $row['student_id']    = $task->student_id;
                     $row['student_name']    = $task->student_name;
                     $row['degree']  = $task->type;
                     $row['size']  = $task->size;
                     $row['color']  = $task->color;
                     fputcsv($file, array($row['class_name'], $row['student_id'], $row['student_name'], $row['degree'], $row['size'],$row['color']));
                 }
     
                 fclose($file);
             };
     
             return response()->stream($callback, 200, $headers);
    }
}
