<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cloth;
use App\Order;
use App\Student;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
class OrderController extends Controller
{
    public function save(){
        /*
        衣物 ID 
        */
        //return Order::find(1)->cloth()->insert(array());
        //$order = new Order();
        //$order->file_id=??
        //$order->student()->associate();
        //$student_id=(int)$request->student_id;
        /*
        Order::with('student')->insert([
            'stu_id'=>403007056,
            'cloth'=>
        ]);
        return 1;
        $order->cloth->create(['cloth'=>1]);
        $order->accessory->create(['accessory '=>1]);
        $order->save();
        
        save(new Cloth($phoneData));
*/
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
        
        //return Cloth::with('order_number')->get(); 
        
    }
}
