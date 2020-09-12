<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Represent;
use App\Department;
use App\Student;
use Illuminate\Validation\ValidationException;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    public function showLoginForm()
    {
        // if(Auth::guard('represent')->check()){
        //     return redirect()->back(); 
        // }
        return view('auth.login');
    }
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }
        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        if($user = Student::where('student_id', $request->username)->where('passwd',md5($request->password))->first()){
            //return md5($request->password);
            Auth::guard('student')->login($user);
            $request->session()->regenerate();
            return redirect()->route('student.page');
        }

        else if($user = Represent::where('class_id', $request->username)->where('passwd',md5($request->password))->first()){
            Auth::guard('represent')->login($user);
            $request->session()->regenerate();
            return redirect()->route('represent.page');
        }

        else if($user = Department::where('department_id', $request->username)->where('passwd',md5($request->password))->first()){
            Auth::guard('department')->login($user);
            $request->session()->regenerate();
            return redirect()->route('department.page');
        }
        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    public function logout(Request $request)
    {
        if(Gate::allows('admin')){
            $this->guard()->logout();
        }
        if(Gate::allows('department')){
            Auth::guard('department')->logout();
        }
        if(Gate::allows('student')){
            Auth::guard('student')->logout();
        }
        else{
            Auth::guard('represent')->logout();
        }
        
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new Response('', 204)
            : redirect('/');
    }

    public function username()
    {
        return 'username';
    }
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:student')->except('logout');
        $this->middleware('guest:represent')->except('logout');
        $this->middleware('guest:department')->except('logout');
    }
}
