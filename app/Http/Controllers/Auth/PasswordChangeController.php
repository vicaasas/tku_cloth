<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use App\Department;
use App\Represent;
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
        else{
            if(Auth::guard('department')->check()){
                $this->saveNewPassword($request,'助教');
            }
            if(Auth::guard('represent')->check()){
                $this->saveNewPassword($request,'畢代');
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
            'user_old_password' => 'required|string|password',
            'new_password' => 'required|confirmed|string|min:8',
        ], [
            'required' => '此欄必填',
            'password' => '密碼不符',
            'string' => '必須使用文字',
            'new_password.confirmed' => '新密碼必須相同',
            'new_password.min' => '新密碼至少必須多於 :min 個字',
        ]);
    }

    protected function saveNewPassword(Request $request,$user_role)
    {
        if($user_role=='助教'){
            $user = Department::find(Auth::guard('department')->user()->department_id);
            $user->passwd = md5($request->input('new_password'));
            $user->save();
        }
        else if($user_role=='畢代'){
            $user = User::find(Auth::guard('department')->user()->class_id);
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
