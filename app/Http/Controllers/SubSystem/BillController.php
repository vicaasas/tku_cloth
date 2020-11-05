<?php

namespace App\Http\Controllers\SubSystem;
use Illuminate\Http\Request;
use App\SubModel\Student;
use App\SubModel\Time;
use App\SubModel\GetClothTime;
use App\SubModel\StudentHaveOrders;
use App\SubModel\Order;
use App\SubModel\Receipt;
use View;
use PDF;
use DB;
use Auth;


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

    public function student_bill_pdf($student_id,$order_id){
        $payment_time = Time::where('content','繳費期限')->first();

        // $student_id=request()->student_id;
        // $order_id=request()->order_id;
        $student_data=Student::where('student_id',$student_id)->first();

        $student_order=StudentHaveOrders::where('stu_id',$student_id)->where('order_id',$order_id)->first();

        if(Gate::allows('admin')){
            $admin=Auth::user();
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
        $bill_pdf=View::make('partial_view.bill',[
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
        //$this->middleware('auth'); 
        //$this->middleware('preventBackHistory'); 
    }
}
