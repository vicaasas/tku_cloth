<?php

namespace App\Http\Middleware;

use Closure;
use App\Order;
use App\Cloth;
Use Exception;
use Auth;
use DB;

class CheckOrderMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {   
        //$obj= new stdClass();
        //print_r( $request->order_property);
        //echo array_count_values(array_column($obj, 'size'))['L'];
        

        $temp_array=array();
        $fail_student=array();
        $not_work=false;
        foreach($request->order_property as $order_property){

            if($order_property["student_id"]!=null&&$order_property['size']!=null&&$order_property['color']!=null){
                
                $student=Order::where('stu_id',$order_property["student_id"])->where('has_cancel',0)->first();
                if ($student != null) {
                    //$index=array_search($order_property["student_id"],$request->order_property);
                    $fail_student[$order_property["student_id"]]=array();
                    array_push($fail_student[$order_property["student_id"]], "fail_hasorder");
                }

                if(!isset($temp_array[$order_property['size']])){
                    $temp_array[$order_property['size']] =  1;
                }
                else{
                    $temp_array[$order_property['size']]++;
                }
                if(!isset($temp_array[$order_property['color']])){
                    $temp_array[$order_property['color']] =  1;
                }
                else{
                    $temp_array[$order_property['size']]++;
                }
                
                try{
                    $cloth_id=Cloth::select(['id'])
                                    ->where('type',Auth::guard('student')->user()->m_or_b)
                                    ->where('property',$order_property['size'])
                                    ->get()[0]->id;
                                
                    $accessory_id=Cloth::select(['id'])
                                ->where('type',Auth::guard('student')->user()->m_or_b)
                                ->where('property',$order_property['color'])
                                ->get()[0]->id;  
                }
                catch(Exception $ex){
                    if(!isset($fail_student[$order_property["student_id"]])){
                        $fail_student[$order_property["student_id"]]=array();
                    }
                    array_push($fail_student[$order_property["student_id"]], "fail_notfound");
                    $not_work=true;
                    //return redirect()->back()->withInput(['old_order'=>$request->order_property])->with('warning', '無法輸入不存在的樣式');
                }
            }
            else{
                if(!isset($fail_student[$order_property["student_id"]])){
                    $fail_student[$order_property["student_id"]]=array();
                }
                array_push($fail_student[$order_property["student_id"]], "fail_inputnull");
                //return redirect()->back()->withInput(['old_order'=>$request->order_property])->with('warning', '欄位不能是空的');
            }
            
        }
        //echo count($temp_array);
        if(count($temp_array)>10){
            $fail_student["over_quantity"]="true";
            //return redirect()->back()->with('warning', '訂單數量不能大於10筆');
        }
        if(!$not_work){
            $remind=DB::table('cloths')->leftJoin('orders',function($l_join){
                $l_join->on('orders.cloth','=','cloths.id')->orOn('orders.accessory','=','cloths.id')->where('orders.has_cancel',0);
            })->select(DB::raw('cloths.type,cloths.name,cloths.property,(cloths.quantity-count(orders.id)) as remainder'))
            ->groupby('cloths.id')
            ->where('cloths.type','=',Auth::guard('student')->user()->m_or_b)
            ->get();
            foreach($temp_array as $temp_array => $value){
                if($remind->where('type',Auth::guard('student')->user()->m_or_b)->where('property',$temp_array)->first()->remainder - $value <=0){
                    if(!isset($fail_student[$order_property["student_id"]])){
                        $fail_student[$order_property["student_id"]]=array();
                    }
                    array_push($fail_student[$temp_array], "is_null");
                    //return redirect()->back()->withInput(['old_order'=>$request->order_property])->with('warning', '衣服尺寸'.$temp_array.'已沒有');
                }
    
            }
        }
       
        if(!empty($fail_student)){
            return redirect()->back()->withInput(['old_order'=>$request->order_property,'fail_student'=>$fail_student]);
        }
        return $next($request);
    }
}
