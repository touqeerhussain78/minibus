<?php

namespace App\Http\Controllers\Operator\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Operator;

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
    protected $redirectTo = '/operator/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       // $this->middleware('guest:operators')->except('logout');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);
        
        $is_active = Operator::where('email', $request->email)->whereStatus(0)->first();
     
        if($is_active){
            return response()->json(['errors' => 'Account is in-active or blocked']);
        }else{
            $result = Auth::guard('operators')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'));
            //dd($result);
            if ($result) {
                //return redirect()->intended('/operators');
                return response()->json(['success' => 'Login Successfully']);
            }else{
                return response()->json(['errors' => 'Credentials do not match']);
            }
            return back()->withInput($request->only('email', 'remember'));
        }
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

    protected function logout() {
        Auth::logout();
         Session::flush();
         //return redirect(\URL::previous());
        return redirect('/');
      }

    
}
