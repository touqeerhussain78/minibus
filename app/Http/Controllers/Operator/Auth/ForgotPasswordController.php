<?php

namespace App\Http\Controllers\Operator\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use App\Token;
use App\Operator;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your operators. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    public function __construct(){
    }

    public function sendVerificationCode(Request $request){
        $operator = Operator::whereEmail($request->email)->first();
        if($operator){
            $token = Token::create([
                'operator_id' => $operator->id
            ]);

            if ($token->sendCodeOperator()) {
                $request->session()->put("token_id", $token->id);
                $request->session()->put("operator_id", $operator->id);
                $request->session()->put("remember", $request->get('remember'));

                return response()->json(['message' => 'Please check your email for password reset code']);
            }

            $token->delete();// delete token because it can't be sent
            return response()->json(['error' => 'Unable to send verification code'], 422);
        }

        return response()->json(['error' => 'Email not found'], 422);
    }

    public function verifyVerificationCode(Request $request){
        if (! $request->session()->has("token_id", "operator_id")) {
            return response()->json(['error' => 'Invalid Operation'], 422);
        }
        $token = Token::find($request->session()->get("token_id"));
        if (! $token ||
            ! $token->isValid() ||
            $request->code !== $token->code 
           // || (int)session()->get("operator_id") !== $token->user->id
        ) {
            return response()->json(['error' => 'Invalid token'], 422);
        }else{
            return response()->json(['message' => 'Verification code accepted']);
        }
    }

    public function updatePassword(Request $request){
        if($request->password == $request->confirm_password && $request->password !== ''){
            if (! $request->session()->has("token_id", "operator_id")) {
                return response()->json(['error' => 'Invalid Operation'], 422);
            }
            $token = Token::find($request->session()->get("token_id"));
            if (! $token ||
                ! $token->isValid() ||
                $request->code !== $token->code 
               // || (int)session()->get("operator_id") !== $token->user->id
            ) {
                return response()->json(['error' => 'Invalid token'], 422);
            }else{
                $user = Operator::find($request->session()->get("operator_id"));
                $user->password = Hash::make($request->password);
                $user->save();

                $token->used = true;
                $token->save();

                return response()->json(['message' => 'Password updated successfully']);

            }
        }
        return response()->json(['error' => 'Password should be same and can not be empty'], 422);


    }


    protected function broker()
    {
        return Password::broker('operators');
    }

    public function sendError($data){
        return ["message" => "The given data was invalid.", "errors" => $data];
    }

    protected function sendResetLinkResponse(Request $request, $response)
    {
        if($request->expectsJson())
            return response()->json(['status' => trans($response)]);
        return back()->with('status', trans($response));
    }

    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        if($request->expectsJson())
            return response()->json($this->sendError(['email' => trans($response)]), 422);
        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => trans($response)]);

    }
}
