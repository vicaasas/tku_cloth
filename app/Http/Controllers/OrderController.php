<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cloth;
use App\Order;
use App\Student;
use App\StudentHaveOrders;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
class OrderController extends Controller
{
    public function __construct(){
        $this->middleware('checkorder'); 
    }
    public function save(){

        if(Auth::guard('student')->check()){
            //return request()->all();
            $student_order=new StudentHaveOrders();
            $student_order->stu_id=Auth::guard('student')->user()->student_id;
            $student_order->save();
            $index=StudentHaveOrders::where('stu_id',Auth::guard('student')->user()->student_id)
                    ->latest('order_id')->first()->order_id;
            foreach(request()->order_property as $order_property){
                $order=new Order();
                
                $order->stu_id=$order_property["student_id"];
                //echo $order->stu_id.'\n';
                $order->order_id=$index;
    
                $order->cloth=Cloth::select(['id'])
                            ->where('type',Auth::guard('student')->user()->m_or_b)
                            ->where('property',$order_property['size'])
                            ->get()[0]->id;
                $order->accessory=Cloth::select(['id'])
                            ->where('type',Auth::guard('student')->user()->m_or_b)
                            ->where('property',$order_property['color'])
                            ->get()[0]->id;            
    
                $order->save();
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
        return redirect()->back()->with('success', '新增更新成功');
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
