<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth, Session;
use Illuminate\Http\Request;
use App\User;

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

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        ///dd($this->middleware('auth:admin'));
        if(Auth::guard('web')->check() || Auth::guard('operators')->check() || Auth::guard('admin')->check()  ){
            return redirect('/home');
        }
        $this->middleware('guest')->except('logout');
    }

    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        $chk =  $this->authenticated($request, $this->guard()->user());

        if (!$chk && $request->wantsJson()) {
            return response()->json(['message' => 'Login Successfull']);
        }
        else if(!$chk){}
        else{
            return redirect()->intended($this->redirectPath());
        }
    }

    protected function login(Request $request)
    {
        $this->validateLogin($request);
        $in_active = User::where('email', $request->email)->where('status', 2)->first();
       
        if($in_active){
            return response()->json(['error' => 'Account is blocked']);
        }
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    public function logout() {
        Auth::logout();
         Session::flush();
         //return redirect(\URL::previous());
        return redirect('/');
      }

    protected function authenticated(Request $request, $user)
    {
        return response()->json(['message' => 'login success', 'token' => csrf_token()]);
    }
}
