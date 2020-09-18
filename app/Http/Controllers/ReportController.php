<?php

namespace App\Http\Controllers;
use App\Student;
use App\Order;
use App\Cloth;
use App\ViewOrder;
use Illuminate\Http\Request;
use DB;
use View;

class ReportController extends Controller
{
    public function __construct(){
        $this->middleware('auth'); 
        $this->middleware('preventBackHistory'); 
    }
    public function get_degree($m_or_b){

        if($m_or_b=='碩士'){
            $class_name=Student::select(Student::raw('class_name'))->where('class_name','like','%碩%')->groupBy('class_name')->get();
        }
        else if($m_or_b=='學士'){
            $class_name=Student::select(Student::raw('class_name'))
                        ->where('class_name','not like','%碩%')
                        ->where('class_name','not like','%博%')
                        ->groupBy('class_name')->get();
        }
        else if($m_or_b=='博士'){
            $class_name=Student::select(Student::raw('class_name'))->where('class_name','like','%博%')->groupBy('class_name')->get();
        }
        $table=View::make('partial_view.order_table',[
            'class_name'=>$class_name,
            'all_cloth'=>Cloth::select(Cloth::raw('property'))->where('type',$m_or_b)->get(),
            'cloth_data'=>DB::table('student_order')->select(DB::raw('class_name,type, cloth, size, COUNT(size) as total'))
                        ->where('type',$m_or_b)
                        ->groupby('class_name','size')
                        ->get(),
            'accessory_data'=>DB::table('student_order')->select(DB::raw('class_name,type, accessory, color, COUNT(color) as total'))
                            ->where('type',$m_or_b)
                            ->groupby('class_name','color')
                            ->get(),
        ]);
        $all_cloth_table=$table->render();
        return 
        [
            'all_cloth_table'=> $all_cloth_table,
        ];

    }
    public function total(){
        // return Student::where('class_name','not like','%碩%')
        //         ->where('class_name','not like','%博%')
        //         ->groupBy('class_name')
        //         ->with(['class_property_counts' => function($query) {
        //             $query//->select(['class_name','type']);
        //             ->rightJoin('cloths as c1',function($r_join){
        //                 $r_join->on('student_order.type', '=', 'c1.type')
        //                 ->on('student_order.cloth', '=', 'c1.name')
        //                 ->on('student_order.size', '=', 'c1.property') 
        //                 ->orOn('student_order.color', '=' ,'c1.property');
        //             }) 
        //             ->select('c1.property','student_order.class_name', DB::raw('count(student_order.student_id) as total'))
        //             ->where('c1.type','學士')->groupby('c1.property');
        //         }])->select('class_name','class_id')
        //         ->get();
        return view('admin.report.total',self::get_degree('學士'));
    }
    public function degree_total(){
        return response()->json(self::get_degree(request()->degree));
    }

    public function class_order($class_name){
        return view('admin.report.class_order',
        [
            "class_name" => $class_name,
            "class_order" =>Student::leftJoin('student_order',function($l_join){
                                        $l_join->on('students.student_id','=','student_order.student_id');
                                    })->select(Student::raw('students.student_id,students.class_id,students.student_name,student_order.size,student_order.color'))
                                    ->where('students.class_name',$class_name)->get(),
        ]);
        

    }
    public function all_student_order(){
        return view('admin.report.student_list',
        [
            "all_student_order" => DB::table('student_order')->select(DB::raw('*'))->get(),
        ]);
        
    }
}
