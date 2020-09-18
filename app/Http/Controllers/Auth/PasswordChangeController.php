<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use App\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PasswordChangeController extends Controller
{
    public function change(Request $request)
    {
        //return Department::find(Auth::guard('department')->user()->department_id);
        $this->validatePassword($request);

        if ($request->input('user_old_password') == $request->input('new_password')) {
            $request->session()->flash('danger', '密碼需與原密碼不同！');
        } 
        if($request->input('new_password_confirmation') != $request->input('new_password')){
            $request->session()->flash('danger', '請確認新密碼輸入是否正確！');
        }
        if(md5($request->input('user_old_password')) != Student::where('student_id',Auth::guard('student')->user()->student_id)->first()->passwd){
            $request->session()->flash('danger', '密碼不符');
        }
        else{
            if(Auth::guard('student')->check()){
                $this->saveNewPassword($request,'學生');
            }
            else{
                $this->saveNewPassword($request,'管理者');
            }
            $request->session()->flash('success', '密碼變更成功！');
        }
        return redirect()->route('profile');
    }

    protected function validatePassword(Request $request)
    {
        $request->validate([
            'user_old_password' => 'required|string',
            'new_password' => 'required|string|min:6',
        ], [
            'required' => '此欄必填',
            //'password' => '密碼不符',
            'string' => '必須使用文字',
            //'new_password.confirmed' => '新密碼必須相同',
            'new_password.min' => '新密碼至少必須多於 :min 個字',
        ]);
    }

    protected function saveNewPassword(Request $request,$user_role)
    {
        if($user_role=='學生'){
            $user = Student::find(Auth::guard('student')->user()->student_id);
            $user->passwd = md5($request->input('new_password'));
            $user->save();
        }

        else if($user_role=='管理者'){
            $user = User::find(Auth::id());
            $user->password = bcrypt($request->input('new_password'));
            $user->save();
        }
        
    }
}
