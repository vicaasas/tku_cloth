<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\View;
use App\Represent;
use App\Time;
use App\Student;
use DB;
class DepartmentController extends Controller
{
    public function __construct(){
        $this->middleware('preventBackHistory'); 
        $this->middleware('auth:department');
    }
    public function index($class_name = null){
        /*
                 @foreach($remainder as $remainder)
            @if($remainder->type==)

            @endif
        @endforeach
         */
        //if(Gate::allows('class',Auth::guard('class'))){
            //return Auth::guard('class')->user();
            //return Auth::guard('department')->user();
            //print_r(DB::select('SELECT c.type,c.name,c.property,(c.quantity-count(o.id)) as remainder FROM `cloths` as c LEFT JOIN orders as o ON o.cloth = c.id or o.accessory = c.id group by c.id'));

            //return View::make('greeting', array('name' => 'Taylor'));
            //return $class_name;
            if($class_name!=null){
                $this_class=Represent::where('class_name',$class_name)->first();
                $this_students=Student::where('class_name',$class_name)->get();
            }
            else{
                $this_class=null;
                $this_students=null;
            }
            return view('index',[
                'user'=>Auth::guard('department')->user(),
                'student'=>$this_students,
                'time'=>Time::where('content','收據列印時間')->get(),
                'class'=>Represent::where('class_id','like','%'.Auth::guard('department')->user()->department_id.'%')->get(),
                'remainder'=>DB::select('SELECT c.type,c.name,c.property,(c.quantity-count(o.id)) as remainder FROM `cloths` as c LEFT JOIN orders as o ON o.cloth = c.id or o.accessory = c.id group by c.id'),
                'this_class'=>$this_class
            ]);

        //}
    }
    public function return_class(Request $request)
    {

        //echo 1;

        $data = Student::where('class_id',$request->class_id)->get();
        $m_or_b=Represent::where('class_id',$request->class_id)->first()->m_or_b;
        //return $m_or_b;
        $table = '    ';
// .'/'.$m_or_b.'
        //echo gettype(DB::select("SELECT * from student_order where class_id = '$request->class_id'"));
        return response()->json(
            [
            'student'=>Student::where('class_id',$request->class_id)->get(),
            'order_table'=>$table,
            ],200);
    }

}
