<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cloth;
use App\Order;
use App\Student;
use App\StudentOrders;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
class OrderController extends Controller
{
    public function save(){
        if(Auth::guard('represent')->check()){
            $user_data=Auth::guard('represent')->user();
            $order=new Order();
            $order->stu_id=request()->student_id;
            //$order->class_id=$user_data->class_id;
            $order->cloth=Cloth::select(['id'])
                        ->where('type',$user_data->m_or_b)
                        ->where('property',request()->size)
                        ->get()[0]->id;
            $order->accessory=Cloth::select(['id'])
                        ->where('type',$user_data->m_or_b)
                        ->where('property',request()->accessory)
                        ->get()[0]->id;            
            //$order->cloth=$order_data[0]->id;
            //$order->accessory=$order_data[1]->id;
            $order->save();
            return redirect()->back()->with('success', '新增訂單成功');
        }
        if(Auth::guard('department')->check()){
            //$user_data=Auth::guard('represent')->user();
            $order=new Order();
            $order->stu_id=request()->student_id;
            //$order->class_id=$user_data->class_id;
            $order->cloth=Cloth::select(['id'])
                        ->where('type',request()->degree)
                        ->where('property',request()->size)
                        ->get()[0]->id;
            $order->accessory=Cloth::select(['id'])
                        ->where('type',request()->degree)
                        ->where('property',request()->accessory)
                        ->get()[0]->id;            
            //$order->cloth=$order_data[0]->id;
            //$order->accessory=$order_data[1]->id;
            $order->save();
            return redirect()->back()->with('success', '新增訂單成功');
        }
        if(Auth::guard('student')->check()){
            //return request()->all();
            $student_order=new StudentOrders();
            $student_order->stu_id=Auth::guard('student')->user()->student_id;
            $student_order->save();
            $index=StudentOrders::where('stu_id',Auth::guard('student')->user()->student_id)
                    ->latest('order_id')->first()->order_id;
            foreach(request()->order_property as $order_property){
                $order=new Order();

                $order->stu_id=Auth::guard('student')->user()->student_id;
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
        StudentOrders::where('order_id', $order_id)->delete();
        return redirect()->back()->with('success', '訂單刪除成功');
    }
}
