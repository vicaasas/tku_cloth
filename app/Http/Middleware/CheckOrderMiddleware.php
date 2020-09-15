<?php

namespace App\Http\Middleware;

use Closure;
use App\Order;
use App\Cloth;
Use Exception;
use Auth;
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

        foreach($request->order_property as $order_property){
            //echo $order_property[student_id;
            $student=Order::where('stu_id',$order_property["student_id"])->first();
            if ($student != null) {
                return redirect()->back()->with('warning', $order_property["student_id"].'學生已訂購');
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
                return redirect()->back()->with('warning', '無法輸入不存在的樣式');
            }
        }
        return $next($request);
    }
}
