<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cloth;
use App\Order;
use App\Student;
use View;
use App\StudentHaveOrders;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
class OrderController extends Controller
{
    // public function __construct(){
    //     $this->middleware('checkorder'); 
    // }
    public function recover_order(){
        $order_id=request()->order_id;
        if(StudentHaveOrders::where('order_id', $order_id)->with('have_orders')->first()->have_orders->isEmpty()){
            StudentHaveOrders::where('order_id', $order_id)->delete();
        }
        $student_order=new StudentHaveOrders();
        $student_order->stu_id=Auth::guard('student')->user()->student_id;
        $student_order->save();
        $now_index=StudentHaveOrders::where('stu_id',Auth::guard('student')->user()->student_id)
                ->latest('id')->first()->id;

        $year=(date("Y") - 1911);
        $filled_id = sprintf("%04d", $now_index);
        $index = $year.$filled_id;
        StudentHaveOrders::where('id',$now_index)->update([
            'order_id'=>$index,
        ]);
        Order::where('order_id', $order_id)->where('has_cancel', 1)
        ->update(
            [
                'order_id'=>$index,
                'has_cancel'=>0,
            ]);
        
    }
    public function save(){

        if(Auth::guard('student')->check()){
            //return gettype(request()->all());
            $student_order=new StudentHaveOrders();
            $student_order->stu_id=Auth::guard('student')->user()->student_id;
            $student_order->save();
            $now_index=StudentHaveOrders::where('stu_id',Auth::guard('student')->user()->student_id)
                    ->latest('id')->first()->id;

            $year=(date("Y") - 1911);
            $filled_id = sprintf("%04d", $now_index);
            $index = $year.$filled_id;
            StudentHaveOrders::where('id',$now_index)->update([
                'order_id'=>$index,
            ]);
            foreach(request()->order_property as $order_property){
                $cloth_id=Cloth::select(['id'])
                        ->where('type',Auth::guard('student')->user()->m_or_b)
                        ->where('property',$order_property['size'])
                        ->get()[0]->id;

                $accessory_id=Cloth::select(['id'])
                        ->where('type',Auth::guard('student')->user()->m_or_b)
                        ->where('property',$order_property['color'])
                        ->get()[0]->id;  
                
                $student_order_cancel=Order::where('stu_id',$order_property['student_id'])->where('has_cancel',1)->first();
                
                if($student_order_cancel!=null){
                    $cancel_id=$student_order_cancel->order_id;
                    $student_order_cancel->update([
                        'order_id'=>$index,
                        'cloth'=>$cloth_id,
                        'accessory'=>$accessory_id,
                        'has_cancel'=> 0 ,
                    ]);
                    if(StudentHaveOrders::where('order_id',$cancel_id)->with('have_orders')->first()->have_orders->isEmpty()){
                        StudentHaveOrders::where('order_id', $cancel_id)->delete();
                    }
                }
                else{
                    $order=new Order();
                
                    $order->stu_id=$order_property["student_id"];
                    //echo $order->stu_id.'\n';
                    $order->order_id=$index;
                    $order->cloth=$cloth_id;
                    $order->accessory=$accessory_id;
        
                    $order->save();
                }

            }
            //return;
            return redirect()->back()->with('success', '新增訂單成功');
        }
    }
    public function order_update(){

        $student_order_id=request()->student_order_id;//得到此訂單在orders中的id
        $cloth_index=Cloth::where('type',Auth::guard('student')->user()->m_or_b)->where('property', '=', request()->size)->first()->id;//得到訂單size
        $accessory_index=Cloth::where('type',Auth::guard('student')->user()->m_or_b)->where('property', '=', request()->color)->first()->id;//得到訂單color
        
        Order::where('id', $student_order_id)
        ->update(
            [
                'cloth' => $cloth_index,
                'accessory' => $accessory_index,
            ],
        );
        return redirect()->back()->with('success', '訂單更新成功');
    }

    public function add_order(){
        $order=new Order();
                
        $order->stu_id=request()->student_id;
        //echo $order->stu_id.'\n';
        $order->order_id=request()->order_id;

        $order->cloth=Cloth::select(['id'])
                    ->where('type',Auth::guard('student')->user()->m_or_b)
                    ->where('property',request()->size)
                    ->get()[0]->id;
        $order->accessory=Cloth::select(['id'])
                    ->where('type',Auth::guard('student')->user()->m_or_b)
                    ->where('property',request()->color)
                    ->get()[0]->id;            

        $order->save();
        return redirect()->back()->with('success', '項目新增成功');
    }
    public function order_delete(){
        $student_order_id=request()->student_order_id;//得到此訂單在orders中的id

        Order::where('id', $student_order_id)->delete();
        return redirect()->back()->with('success', '項目刪除成功');
    }
    public function student_all_order_delete(){
        $order_id=request()->order_id;//得到此訂單在orders中的id

        Order::where('order_id', $order_id)->delete();
        StudentHaveOrders::where('order_id', $order_id)->delete();
        return redirect()->back()->with('success', '訂單刪除成功');
    }
    public function get_cloths(){
        $index=request()->get_id;
        $student_order=StudentHaveOrders::where('stu_id',$index)->first();
        if($student_order!=null){
            $table=View::make('partial_view.student_cloths',[
                'student_order'=>StudentHaveOrders::where('stu_id',$index)->where('has_paid',1)->with('have_orders')->get(),
            ]);
            $student_table=$table->render();

        }
        else{
            $table=View::make('partial_view.student_cloths',[
                'student_order'=>StudentHaveOrders::where('order_id',$index)->where('has_paid',1)->with('have_orders')->get(),
            ]);
            $student_table=$table->render();

        }
        return view('admin.report.get_cloths',
        [
            'student_table'=> $student_table,
        ]);

    }
    public function is_get_cloths(){
        $order_id=request()->order_id;//得到此訂單在orders中的id

        StudentHaveOrders::where('order_id', $order_id)
        ->update(
            [
                'has_get_cloths' => 1,
            ],
        );
    }
    public function order_return(){
        $order_id=request()->order_id;//得到此訂單在orders中的id

        StudentHaveOrders::where('order_id', $order_id)
        ->update(
            [
                'return' => 1,
            ],
        );
        return redirect()->back()->with('success', '訂單歸還成功');
    }

}
