<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Represent;
use App\Time;
use App\Student;
use App\Cloth;
use App\Order;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
class RepresentController extends Controller
{
    public function __construct(){
        
        $this->middleware('preventBackHistory'); 
        $this->middleware('auth:represent');
        //$this->middleware('guest:represent'); 
    }

    public function index(){
/* 
CREATE OR REPLACE VIEW student_order AS
SELECT students.student_id, students.class_id, students.class_name, students.student_name, cloths1.type AS type, cloths1.name AS cloth, cloths1.property AS size, cloths2.name AS accessory, cloths2.property AS color,orders.state
FROM orders
INNER JOIN students ON students.student_id=orders.stu_id
INNER JOIN cloths cloths1 ON orders.cloth=cloths1.id 
INNER JOIN cloths cloths2 ON orders.accessory=cloths2.id
*/
//$quantity=DB::select('SELECT cloths.type, cloths.name, cloths.property,(cloths.quantity-COUNT(student_order.color)) as total FROM cloths INNER JOIN student_order on student_order.color=cloths.property where cloths.type = "碩士" GROUP BY student_order.color');
            //return 
            $user_data=Auth::guard('represent')->user();
/* SELECT c.id,count(o.id) FROM `cloths` as c LEFT JOIN orders as o ON o.cloth = c.id or o.accessory = c.id group by c.id*/
            //return DB::select("SELECT * from student_order where class_id = '$user_data->class_id'");
            /*
            

            $quantity_record=Cloth::all();
            $quantity_record_array=array_column(json_decode($quantity_record, true), 'id');
            $cloth_quantity=Order::select(Order::raw('cloth,count(cloth) as cloth_q'))
                            ->groupBy('cloth')
                            ->get();
            $accessory_quantity=Order::select(Order::raw('accessory, count(accessory) as accessory_q'))
                            ->groupBy('accessory')
                            ->get();
            
            foreach($cloth_quantity as $cloth_quantity){
                $cloth_id = array_search($cloth_quantity->cloth, $quantity_record_array);
                echo $quantity_record[$cloth_id]->quantity - $cloth_quantity->cloth_q.'<br>';
                   
            }
            foreach($accessory_quantity as $accessory_quantity){

                $accessory_id= array_search($accessory_quantity->accessory, $quantity_record_array);
                echo $quantity_record[$accessory_id]->quantity - $accessory_quantity->accessory_q.'<br>';                                    
            }
            */
            
            return view('index',[
                'user'=>$user_data,
                'time'=>Time::where('content','收據列印時間')->get(),
                'student'=>Student::where('class_id',$user_data->class_id)->get(),
                'student_order'=>DB::table('student_order')->select('*')->where('class_id', '=', $user_data->class_id)->get(),
                'remainder'=>DB::table('cloths')->leftJoin('orders',function($l_join){
                                $l_join->on('orders.cloth','=','cloths.id')->orOn('orders.accessory','=','cloths.id');
                            })->select(DB::raw('cloths.type,cloths.name,cloths.property,(cloths.quantity-count(orders.id)) as remainder'))
                            ->groupby('cloths.id')
                            ->where('cloths.type','=',$user_data->m_or_b)
                            ->get(),

            ]);
        //}
    }
}
