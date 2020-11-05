<?php

namespace App\Http\Controllers\SubSystem;

use App\SubModel\Order;
use App\SubModel\User;
use App\SubModel\Student;
use DB;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Schema;
//use Illuminate\Support\Facades\Auth;
class SystemController extends Controller
{
    public function __construct(){
        $this->middleware('preventBackHistory'); 
    }
    public function index()
    {
        //return explode(',',env('HISTORY_DATABASE',null),-1);
        return view('admin.system.index',[
            'history_rent_cloth'=>explode(',',env('HISTORY_DATABASE',null),-1),
        ]);
    }

    public function new_user(Request $request)
    {
        $this->validateUser($request);

        
        if ($request->has('stu_id')) {
            // 學生
            $student = new Student();
            $student->student_id = $request->stu_id;
            $student->password = md5(substr($request->stu_id, 3, 6));
            $student->student_name = $request->name;
            $student->class_name = $request->class_name;
            $user->class_id = $request->class_id;
            $user->save();
        } else {
            // 管理員
            $user = new User();
            $user->name = $request->admin_name;
            $user->username = $request->username;
            $user->password = bcrypt($request->password);
            $user->role = $request->admin_authority;
            $user->base64Img = '';
            $user->save();
        }

        $request->session()->flash('success', '使用者新增成功！');
        return $this->redirectAfterDone();
    }
    public function give_admin_authority(Request $request)
    {
        User::where('username',$request->account)->update([
            'role'=>$request->give_admin_authority,
        ]);
        $request->session()->flash('success', '授權成功！');
        return redirect()->route('system.index');
    }

    private function validateUser(Request $request)
    {
        // if ($request->has('name')) {
        //     // 學生
        //     $request->validate([
        //         'stu_id' => 'required|numeric',
        //         'name' => 'required|string',
        //         'department' => [
        //             'required',
        //             Rule::in([User::DEPARTMENT_BACHELOR, User::DEPARTMENT_MASTER, User::DEPARTMENT_DOCTOR]),
        //         ],
        //         'class' => 'required|string',
        //     ]);
        // } else {
            // 管理員
            $request->validate([
                'username' => 'required|string',
                'password' => 'required|confirmed|string|min:8',
            ]);
        //}

    }
    public function recover_password(Request $request)
    {
        Student::where('student_id',$request->recover_stu_id)->update([
            'passwd'=>md5(substr($request->recover_stu_id, 3, 6)),
        ]);
        $request->session()->flash('success', '學生密碼還原成功！');
        return redirect()->route('system.index');
    }


    public function importstudent(Request $request){
        //return Auth::user()->username;
        $request->validate(
        [
            'csv_file'=>'required|mimes:csv,txt',
        ]);
        
        $path = $request->file('csv_file')->getRealPath();
        
        $file = file($path);
        //return $file;
        $rows = array_map('str_getcsv', $file);
        $rows = mb_convert_encoding($rows, "UTF-8", "big5");
        array_walk($rows, function(&$a) use ($rows) {
            $a = array_combine($rows[0], $a);
        });
        array_shift($rows);

        $count=0;
        foreach($rows as $index){
            
            // if($count==25){
            //     break;
            // }
            $student = new Student();
            $student->student_id = $index['student_id'];
            $student->class_id = $index['class_id'];
            $student->class_name = $index['class_name'];
            $student->student_name = $index['student_name'];
            $student->passwd = md5(substr($index['student_id'], 3, 6));
            $student->semester = $index['semester'];
            $student->save();
            $count++;
        }
        $request->session()->flash('success', '學生資料匯入成功！');
        return $this->redirectAfterDone();
        
    }

    private function redirectAfterDone()
    {
        return redirect()->route('system.index');
    }

    public function dropStudents(Request $request)
    {
        //Schema::dropIfExists('orders');
        DB::table('students')->delete();
        //Student::truncate();
        // $orders = Order::all();
        // foreach ($orders as $order) {
        //     $order->delete();
        // }

        // $students = User::all()->where('role', User::ROLE_STUDENT);
        // foreach ($students as $student) {
        //     $student->delete();
        // }

        $request->session()->flash('success', '資料清除完畢！');
        return $this->redirectAfterDone();
    }


}