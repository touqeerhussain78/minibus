<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Token;
use App\User;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    public function sendVerificationCode(Request $request){
        $user = User::whereEmail($request->email)->first();
        if($user){
            $token = Token::create([
                'user_id' => $user->id
            ]);

            if ($token->sendCode()) {
                $request->session()->put("token_id", $token->id);
                $request->session()->put("user_id", $user->id);
                $request->session()->put("remember", $request->get('remember'));

                return response()->json(['message' => 'Please check your email for password reset code']);
            }

            $token->delete();// delete token because it can't be sent
            return response()->json(['error' => 'Unable to send verification code'], 422);
        }

        return response()->json(['error' => 'Email not found'], 422);
    }

    public function verifyVerificationCode(Request $request){
        if (! $request->session()->has("token_id", "user_id")) {
            return response()->json(['error' => 'Invalid Operation'], 422);
        }
        $token = Token::find($request->session()->get("token_id"));
        if (! $token ||
            ! $token->isValid() ||
            $request->code !== $token->code ||
            (int)session()->get("user_id") !== $token->user->id
        ) {
            return response()->json(['error' => 'Invalid token'], 422);
        }else{
            return response()->json(['message' => 'Verification code accepted']);
        }
    }

    public function updatePassword(Request $request){
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'max:15', 'confirmed'],
            'password_confirmation' => ['required', 'string', 'min:8', 'max:15']
        ],[
            'password.required' => 'New Password field is required.'
        ]
    );
        if($request->password == $request->password_confirmation && $request->password !== ''){
            if (! $request->session()->has("token_id", "user_id")) {
                return response()->json(['error' => 'Invalid Operation'], 422);
            }
            $token = Token::find($request->session()->get("token_id"));
            if (! $token ||
                ! $token->isValid() ||
                $request->code !== $token->code ||
                (int)session()->get("user_id") !== $token->user->id
            ) {
                return response()->json(['error' => 'Invalid token'], 422);
            }else{
                $user = User::find($request->session()->get("user_id"));
                $user->password = Hash::make($request->password);
                $user->save();

                $token->used = true;
                $token->save();

                return response()->json(['message' => 'Password updated successfully']);

            }
        }
        return response()->json(['error' => 'Password should be same and can not be empty'], 422);


    }

    public function sendError($data){
        //{"message":"The given data was invalid.","errors":{"email":["The email field is required."]}}
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