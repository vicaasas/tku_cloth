<?php

namespace App\Http\Middleware;

use Closure;

class SingleOrder
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
                
 

        if($request->student_id!=null&&$request->size!=null&&$request->color!=null){
            
            $student=Order::where('stu_id',$request->student_id)->where('has_cancel',0)->first();
            if ($student != null) {
                return redirect()->back()->with('warning', $request->student_id.'學生已訂購');
            }

            
            try{
                $cloth_id=Cloth::select(['id'])
                                ->where('type',Auth::guard('student')->user()->m_or_b)
                                ->where('property',$request->size)
                                ->get()[0]->id;
                            
                $accessory_id=Cloth::select(['id'])
                            ->where('type',Auth::guard('student')->user()->m_or_b)
                            ->where('property',$request->color)
                            ->get()[0]->id;  
            }
            catch(Exception $ex){
                return redirect()->back()->with('warning', '無法輸入不存在的樣式');
            }
        }
        else{
            return redirect()->back()->with('warning', '欄位不能是空的');
        }
        $order_count=Order::where('order_id',$request->order_id)->where('has_cancel',0)->get();
        if($order_count->count()>=10){
            return redirect()->back()->with('warning', '此訂單數量已超過10筆');
        }

        $remind=DB::table('cloths')->leftJoin('orders',function($l_join){
            $l_join->on('orders.cloth','=','cloths.id')->orOn('orders.accessory','=','cloths.id')->where('orders.has_cancel',0);
        })->select(DB::raw('cloths.type,cloths.name,cloths.property,(cloths.quantity-count(orders.id)) as remainder'))
        ->groupby('cloths.id')
        ->where('cloths.type','=',Auth::guard('student')->user()->m_or_b)
        ->get();
        if($remind->where('type',Auth::guard('student')->user()->m_or_b)->where('property',$request->size)->first()->remainder - 1 <0){
            //return redirect('/')->withInput();
            return redirect()->back()->with('warning', '衣服尺寸'.$request->size.'已沒有');
        }
        if($remind->where('type',Auth::guard('student')->user()->m_or_b)->where('property',$request->color)->first()->remainder - 1 <0){
            //return redirect('/')->withInput();
            return redirect()->back()->with('warning', '配件顏色'.$request->color.'已沒有');
        }
        return $next($request);
    }
}
