<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cloth;
use App\Order;
use App\Student;
use App\GetClothTime;
use View;
use App\StudentHaveOrders;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
class OrderController extends Controller
{
    // public function __construct(){
    //     $this->middleware('checkorder'); 
    // }
    //學生的功能
    public function recover_order(){
        $validatedData = request()->validate([
            'get_time_id' => 'required',
        ]);
    
        if(request()->get_time_id==null){
            return redirect()->back()->withInput(['old_order'=>request()->order_property,'fail'=>"請選擇領取時間"]);
        }
        $order_id=request()->order_id;
        $get_time_id=request()->get_time_id;
        if(StudentHaveOrders::where('order_id', $order_id)->with('have_orders')->first()->have_orders->isEmpty()){
            StudentHaveOrders::where('order_id', $order_id)->delete();
        }
        $student_order=new StudentHaveOrders();
        $student_order->stu_id=Auth::guard('student')->user()->student_id;
        $student_order->get_time_id=$get_time_id;
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
        return redirect()->back()->with('success', '恢復訂單成功');
    }
    public function save(){
        
        if(Auth::guard('student')->check()){
            //return request()->all();
            $student_order=new StudentHaveOrders();
            $student_order->stu_id=Auth::guard('student')->user()->student_id;
            $student_order->get_time_id=request()->get_time_id;
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
    // public function order_update(){

    //     $student_order_id=request()->student_order_id;//得到此訂單在orders中的id
    //     $cloth_index=Cloth::where('type',Auth::guard('student')->user()->m_or_b)->where('property', '=', request()->size)->first()->id;//得到訂單size
    //     $accessory_index=Cloth::where('type',Auth::guard('student')->user()->m_or_b)->where('property', '=', request()->color)->first()->id;//得到訂單color
        
    //     Order::where('id', $student_order_id)
    //     ->update(
    //         [
    //             'cloth' => $cloth_index,
    //             'accessory' => $accessory_index,
    //         ],
    //     );
    //     return redirect()->back()->with('success', '訂單更新成功');
    // }

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
        $order_id=request()->order_id;//得到此訂單在StudentHaveOrders中的id
        StudentHaveOrders::where('order_id', $order_id)->delete();
        return redirect()->back()->with('success', '訂單刪除成功');
    }

    //學生與管理者共同功能
    public function order_edit(){

        $type=Student::where('student_id',request()->student_id)->first()->m_or_b;
        $cloth_index=Cloth::where('type',$type)->where('property', '=', request()->size)->first()->id;
        $accessory_index=Cloth::where('type',$type)->where('property', '=', request()->color)->first()->id;
        
        Order::where('stu_id', request()->student_id)
        ->update(
            [
                'cloth' => $cloth_index,
                'accessory' => $accessory_index,
            ],
        );
        return redirect()->back()->with('success', '訂單編輯成功');

    }

    //管理者功能
    public function order_cancel(){

        Order::where('order_id',request()->order_id)->where('stu_id', request()->student_id)->update(['has_cancel' => 1]);
        // if(Order::where('order_id',request()->order_id)->first()==null){
        //     StudentHaveOrders::where('order_id',request()->order_id)->delete();
        // }
        // foreach($select_column_data as $key => $value){
            
        // }
        return 1;

    }
    public function get_cloths_order(){
        $get_time=GetClothTime::all();

        foreach($get_time as $get_time){
            //echo strtotime($get_time->start_time)-strtotime(date("Y-m-d")).'<br>';
            if(strtotime($get_time->start_time)-strtotime(date("Y-m-d"))>0){
                $time_index = $get_time->id;
            }
        }
        //return 1;
        $index=request()->get_id;
        $student_order=StudentHaveOrders::where('stu_id',$index)->first();
        if($student_order!=null){
            $table=View::make('partial_view.get_student_cloths',[
                'student_order'=>StudentHaveOrders::where('stu_id',$index)->where('has_paid',1)->with('have_orders')->get(),
            ]);
            $student_table=$table->render();

        }
        else{
            $table=View::make('partial_view.get_student_cloths',[
                'student_order'=>StudentHaveOrders::where('order_id',$index)->where('has_paid',1)->with('have_orders')->get(),
            ]);
            $student_table=$table->render();

        }
        return view('admin.function_page.get_cloths',
        [
            //'order_list'=>StudentHaveOrders::where('get_time_id',$time_index)->where('has_paid',1)->with('have_orders')->get(),
            'student_table'=> $student_table,
        ]);

    }
    public function determine_get_cloths(){
        $order_id=request()->order_id;//得到此訂單在orders中的id

        StudentHaveOrders::where('order_id', $order_id)
        ->update(
            [
                'has_get_cloths' => 1,
            ],
        );
        return 1;
    }

}
