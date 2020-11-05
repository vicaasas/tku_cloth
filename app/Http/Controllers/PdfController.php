<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Time;
use App\GetClothTime;
use DB;
use PDF;
use View;
use Auth;
use Gate;
use App\Config;
use App\Student;
use App\StudentHaveOrders;
class PdfController extends Controller
{

    public function not_return(){
        $not_return_order = DB::table('student_order')->select(DB::raw('*'))->where('type',request()->degree)->where('return',0)->where('has_get_cloths',1)->get();   
        $not_return_pdf=View::make('create_pdf.pdf_order_table',[
            'degree'=>request()->degree,
            'pdf_name'=>"未歸還名單",
            'return_order_state'=>$not_return_order,
        ]);   
        $html = $not_return_pdf->render();
        $pdf = PDF::loadHTML($html)->setOption('footer-center', '第 [page] 頁');
        return $pdf->stream('未歸還名單.pdf');

    }
    public function is_return(){
        $is_return_order = DB::table('student_order')->select(DB::raw('*'))->where('type',request()->degree)->where('return',1)->get();   
        $is_return_pdf=View::make('create_pdf.pdf_order_table',[
            'degree'=>request()->degree,
            'pdf_name'=>"已歸還名冊",
            'return_order_state'=>$is_return_order,
        ]);   
        $html = (string)$is_return_pdf;

        $pdf = PDF::loadHTML($html)->setOption('footer-center', '第 [page] 頁');
        return $pdf->stream('已歸還名冊.pdf');
    }
    public function receipt_bail(){
        $is_return_order = DB::table('student_order')->select(DB::raw('*'))->where('has_paid',1)->where('has_get_cloths',1)->get();   
        $student_data=Auth::guard('student')->user();
        if($student_data->m_or_b=="碩士"){
            $student_data->setAttribute('margin', 1000);
            $student_data->setAttribute('cleanfee', 200);
            $student_data->setAttribute('clothes', 1200);
            $student_data->setAttribute('hat', 350);
            $student_data->setAttribute('scarf', 800);
            $student_data->setAttribute('hatear', 50);
        }
        else{
            $student_data->setAttribute('margin', 500);
            $student_data->setAttribute('cleanfee', 100);
            $student_data->setAttribute('clothes', 300);
            $student_data->setAttribute('hat', 120);
            $student_data->setAttribute('scarf', 80);
            $student_data->setAttribute('hatear', 20);
        }
        $return_due_date=Time::where('content','借用時間')->first();
        $this_year = explode('-', $return_due_date->end_time);
        $year = $this_year[0] - 1911;
        $is_return_pdf=View::make('create_pdf.receipt_bail',[
            'student_data'=>$student_data,
            'year'=>(date("Y") - 1911),
            'month'=>date("m"),
            'day'=>date("d"),
            'year'=>$year,
            'return_due_date'=>$return_due_date,
            'collection_place'=>Config::where('key','歸還地點')->first(),
        ]);   
        $html = (string)$is_return_pdf;
        //return $html;
        //
        $pdf = PDF::loadHtml($html)->setPaper('a5', 'landscape');
        
        return $pdf->stream('保證金繳費證明.pdf');
    }

    public function student_bill_pdf($student_id,$order_id){
        $payment_time = Time::where('content','繳費期限')->first();

        // $student_id=request()->student_id;
        // $order_id=request()->order_id;
        $student_data=Student::where('student_id',$student_id)->first();

        $student_order=StudentHaveOrders::where('stu_id',$student_id)->where('order_id',$order_id)->first();

        if(Gate::allows('admin')){
            $admin=Auth::user()->name;
        }
        else{
            $admin=null;
        }
        if($student_data->m_or_b=="碩士"){
            $cloth_pick_time=GetClothTime::where('id',$student_order->get_time_id)->first();
        }
        else{
            $cloth_pick_time=GetClothTime::where('id',$student_order->get_time_id)->first();
        }
        $bill_pdf=View::make('create_pdf.bill',[
            'student_data'=>$student_data,
            'student_order'=>StudentHaveOrders::where('stu_id',$student_id)->where('order_id',$order_id)->with('have_orders')->first(),
            'payment_time'=>$payment_time,
            'cloth_pick_time'=>$cloth_pick_time,
            'bill_receipt'=>['繳費收據(事務整備組)','繳款人收據'],
            'admin'=>$admin,
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

    public function bill_proof(){
        $is_return_order = DB::table('student_order')->select(DB::raw('*'))->where('has_paid',1)->where('has_get_cloths',1)->get();   
        $student_data=Auth::guard('student')->user();
        if($student_data->m_or_b=="碩士"){
            $student_data->setAttribute('margin', 1000);
            $student_data->setAttribute('cleanfee', 200);
            $student_data->setAttribute('clothes', 1200);
            $student_data->setAttribute('hat', 350);
            $student_data->setAttribute('scarf', 800);
            $student_data->setAttribute('hatear', 50);
        }
        else{
            $student_data->setAttribute('margin', 500);
            $student_data->setAttribute('cleanfee', 100);
            $student_data->setAttribute('clothes', 300);
            $student_data->setAttribute('hat', 120);
            $student_data->setAttribute('scarf', 80);
            $student_data->setAttribute('hatear', 20);
        }
        $return_due_date=Time::where('content','借用時間')->first();
        $this_year = explode('-', $return_due_date->end_time);
        $year = $this_year[0] - 1911;
        $is_return_pdf=View::make('create_pdf.receipt_proof',[
            'student_data'=>$student_data,
            'year'=>(date("Y") - 1911),
            'month'=>date("m"),
            'day'=>date("d"),
            'year'=>$year,
            'return_due_date'=>$return_due_date,
            'collection_place'=>Config::where('key','歸還地點')->first(),
        ]);   
        $html = (string)$is_return_pdf;
        //return $html;
        //
        $pdf = PDF::loadHtml($html)->setPaper('a5', 'landscape');
        
        return $pdf->stream('洗滌及折舊費繳費證明.pdf');
    }
    public function exportCsv()
    {
        $year=substr(env('DB_DATABASE'),0,3);
        $fileName = $year.'訂單詳細資訊.csv';
        $tasks = DB::table('student_order')->where('has_paid',1)->get();
     
             $headers = array(
                 "Content-type"        => "text/csv",
                 "Content-Disposition" => "attachment; filename=$fileName",
                 "Pragma"              => "no-cache",
                 "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                 "Expires"             => "0"
             );
     
             $columns = array('訂單編號','班級', '學號', '姓名', '學位', '尺寸','顏色','代訂人','收據編號','收據登入時間');
     
             $callback = function() use($tasks, $columns) {
                 $file = fopen('php://output', 'w');
                 fwrite($file, chr(0xEF).chr(0xBB).chr(0xBF));
                 fputcsv($file, $columns);
     
                 foreach ($tasks as $task) {
                     $row['訂單編號']  = $task->order_id;
                     $row['班級']  = $task->class_name;
                     $row['學號']    = $task->student_id;
                     $row['姓名']    = $task->student_name;
                     $row['學位']  = $task->type;
                     $row['尺寸']  = $task->size;
                     $row['顏色']  = $task->color;
                     $row['代訂人']  = $task->responsible_person;
                     $row['收據編號']  = $task->receipt_no;
                     $row['收據登入時間']  = $task->receipt_date;
                     fputcsv($file, array($row['訂單編號'],$row['班級'], $row['學號'], $row['姓名'], $row['學位'], $row['尺寸'],$row['顏色'],$row['代訂人'],$row['收據編號'],$row['收據登入時間']));
                 }
     
                 fclose($file);
             };
     
             return response()->stream($callback, 200, $headers);
    }
}
