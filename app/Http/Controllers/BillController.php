<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Student;
use App\Time;
use App\StudentHaveOrders;
use App\Receipt;
use View;
use PDF;
use DB;
use Auth;


class BillController extends Controller
{
    public function bill(){
        return view('admin.report.bill',
        [
            'class_name'=>Student::select(Student::raw('class_name'))->groupBy('class_name')->get(),
        ]);
    }
    public function order_table($index){
        $student_order=StudentHaveOrders::where('stu_id',$index)->first();
        if($student_order!=null){
            $table=View::make('partial_view.student_order',[
                'student_order'=>StudentHaveOrders::where('stu_id',$index)->with('have_orders')->get(),
            ]);
            $student_table=$table->render();
            return 
            [
                'student_table'=> $student_table,
            ];
        }
        else{
            $table=View::make('partial_view.student_order',[
                'student_order'=>StudentHaveOrders::where('order_id',$index)->with('have_orders')->get(),
            ]);
            $student_table=$table->render();
            return 
            [
                'student_table'=> $student_table,
            ];
        }
        
    }
    
    public function student_bill(){
        //return response()->json(['student_table'=> StudentHaveOrders::where('order_id',request()->get_id)->with('have_orders')->get(),]);
        return view('admin.report.bill',self::order_table(request()->get_id));
        //return response()->json(self::order_table(request()->get_id));
    }
    // public function bill_id(){
    //     return response()->json(self::order_table(request()->get_id));

    // }
    public function get_receipt(){
        $receipt=new Receipt();
        $receipt->receipt_no = request()->recipient_id;
        $receipt->order_id = request()->order_id;
        $receipt->payer = request()->student_id;

        $receipt->pay_date = request()->recipient_date;
        $receipt->save();
        StudentHaveOrders::where('order_id',request()->order_id)->update([
            'has_paid'=>1,
        ]);
        return redirect()->back()->with('success', '收據輸入成功');
    }
    
    public function __construct(){
        $this->middleware('auth'); 
        $this->middleware('preventBackHistory'); 
    }
}
