<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Student;
use App\Time;
use App\GetClothTime;
use App\StudentHaveOrders;
use App\Order;
use App\Receipt;
use View;
use PDF;
use DB;
use Auth;
use Gate;

class BillController extends Controller
{
    public function bill(){
        return view('admin.function_page.bill',
        [
            'class_name'=>Student::select(Student::raw('class_name'))->groupBy('class_name')->get(),
        ]);
    }
    public function student_bill(){
        $index=request()->get_id;
        $student_order=StudentHaveOrders::where('stu_id',$index)->first();
        if($student_order!=null){
            $table=View::make('partial_view.student_order',[
                'student_order'=>StudentHaveOrders::where('stu_id',$index)->with('have_orders')->with('get_counts')->get(),

            ]);
            $student_table=$table->render();

        }
        else{
            $table=View::make('partial_view.student_order',[
                'student_order'=>StudentHaveOrders::where('order_id',$index)->with('have_orders')->with('get_counts')->get(),
            ]);
            $student_table=$table->render();

        }
        //return response()->json(['student_table'=> StudentHaveOrders::where('order_id',request()->get_id)->with('have_orders')->get(),]);
        return view('admin.function_page.bill',[
            'student_table'=> $student_table,
        ]);
        //return response()->json(self::order_table(request()->get_id));
    }


    public function get_receipt(){
        $receipt=new Receipt();
        $receipt->receipt_no = request()->recipient_id;
        $receipt->order_id = request()->order_id;
        $receipt->payer = request()->student_id;

        $receipt->receipt_date = request()->recipient_date;
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
