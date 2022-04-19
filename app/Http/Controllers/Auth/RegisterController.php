<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Notifications\UserRegistration;
use App\Chat\Soachat;
use Session;
use App\Mail\RegisterVerificationCode;
use App\Notifications\AdminNotification;
use App\Admin;
use Twilio\Rest\Client;
use Twilio\Jwt\ClientToken;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
           // 'password' => ['required', 'string', 'min:8', 'confirmed'],
          //  'address' => ['required', 'string', 'max:255'],
          //  'city' => ['required', 'string'],
          //  'phone' => ['required', 'string', 'max:15'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        // $uuid = Str::uuid();
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'address' => $data['address'],
            'city' => $data['city'],
            'zipcode' => $data['zipcode'],
            'phone' => $data['phone'],
            'auth_code_phone' => $this->generateCodePhone(4),
            'auth_code_email' => $this->generateCodeEmail(8),
            // 'uuid'=> $uuid


        ]);

        if(isset($data['file'])){
            $path = 'users/'.md5($user->id).'/minibus/';
            $image = self::upload($data['file'], $path, 'public', null);

            $user->image = $image;
            $user->save();
        }
        
        return $user;
    }

    public function registerUser(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'surname' => ['required', 'string', 'max:100', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'address' => ['required', 'string'],
            'phone' => ['required', 'min:8']
        ],[
            'surname.required' => 'The Surname field is required',
            'surname.string' => 'The Surname field should be string',
            'surname.max' => 'The Surname field maximum characters should be 100',
            'surname.unique' => 'The Surname has already been taken',
            'phone.min' => 'Phone must be atleast 8 digits'
        ]
    );
       
        if(isset($request['file']) && $request['file'] !== 'undefined'){
            $path = 'users'.md5($request['phone']).'/minibus/';
            $image = self::upload($request->file('file'), $path, 'public', null);
        }

        $code = $this->generateCodePhone(4);

        Session::put('user_data', 
        [
            'name' => $request['name'],
            'surname' => $request['surname'],
            'email' => $request['email'],
            'address' => $request['address'],
            'city' => $request['city'],
            'state' => $request['state'],
            'country' => $request['country'],
            'zipcode' => $request['zipcode'],
            'phone_no' => $request['phone'],
            'auth_code_phone' => $code,
            'auth_code_email' => $this->generateCodeEmail(8),
            'image' => $image ?? ""
        ]);
        $user_data = Session::get('user_data');

        $accountSid = config('app.twilio')['TWILIO_ACCOUNT_SID'];
        $authToken  = config('app.twilio')['TWILIO_AUTH_TOKEN'];
        $client = new Client($accountSid, $authToken);
        try
        {
            $response = $client->messages->create(
                $request['phone'],
            array(
                    'from' => '+18474534323',
                    'body' => 'Thanks for using Minibus. Your phone verification code is '.$code
                )
            );

            
        }
        catch (Exception $e)
        {
            
            echo "Error: " . $e->getMessage();
            return response()->json(['errors'=>$e->getMessage()], 422);
        }
        try{
            \Mail::to($request['email'])->send(new RegisterVerificationCode($user_data));
        }catch(\Exception $ex){}
        
        return response()->json(['success'=>true, 'data'=>$user_data]);
    }

    

    protected function register(Request $request)
    {
        $this->validator($request->all())->validate();

       // event(new Registered($user = $this->create($request->all())));

        //$this->guard()->login($user);

        //return $this->registered($request, $user) ?: redirect($this->redirectPath());
        
        return response()->json([
            'status'=>true,
            'data' => $user,
            'message'=> 'User created successfully'
        ], 200);
    }

    public function verifyAccount(Request $request) {
       
        $request->validate([
            'auth_phone' => ['required', 'string'],
            'auth_email' => ['required', 'string']
        ]);

        $user = Session::get('user_data');
        
        if(($user['auth_code_phone'] == $request->auth_phone) && ($user['auth_code_email'] == $request->auth_email)){
            return response()->json([
                'status'=>true,
                'message'=> 'Account verified successfully'
            ], 200);
        }else{
            return response()->json([ 
                'status'=>false,
                'message'=> 'Invalid verification code'], 200);
        }
    }

    public function resend() {
      
        $user_data = Session::get('user_data');
       
        $accountSid = config('app.twilio')['TWILIO_ACCOUNT_SID'];
        $authToken  = config('app.twilio')['TWILIO_AUTH_TOKEN'];
        $client = new Client($accountSid, $authToken);
        try
        {
            $client->messages->create(
            $user_data['phone_no'],
            array(
                    'from' => '+18474534323',
                    'body' => 'Thanks for using Minibus. Your phone verification code is '.$user_data['auth_code_phone']
                )
            );
        }
        catch (Exception $e)
        {
            //echo "Error: " . $e->getMessage();
        }
        try{
            \Mail::to($user_data['email'])->send(new RegisterVerificationCode($user_data));
        }catch(\Exception $ex){}
        
        return response()->json([
            'status'=>true,
            'message'=> 'Verification code sent. Please check your email and phone.'
        ], 200);
    }

    public function setpassword(Request $request) 
    {
        
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ]);

        $data = Session::get('user_data');
        $uuid = Str::uuid();
        $user = new User();
        $data['password'] = bcrypt($request['password']);
        $data['status'] = 1;
        $user->fill($data);
        $user->image = $data['image'] ?? '';
        $user->uuid = $uuid;
        $user->save();
        
        Soachat::addUser($user->uuid, $user->name, NULL, 0);
        $user->notify(new UserRegistration('user'));
        \Notification::send(Admin::all(), new AdminNotification('User Registered', 'A new user has been registered on Minibus'));
        // unset session
        Session::forget('user_data');

        return response()->json([
            'status'=>true,
            'message'=> 'Account registered successfully'
        ], 200);
        
    }

    public function changePassword(Request $request){
      
        $id = \Auth::user()->id;
       
        $this->validate($request, [
            'email'     => ['required', 'string', 'email'],
            'password'     => 'required|min:6',
            'confirm_password' => 'required|same:password',
        ]);
     
        
        $update = User::where('email', $request->email)->update([
               'password'=> Hash::make($request->password)
           ]);
           return response()->json(['msg' => 'Pasword updated successfully'], 200);
        
    }

    public static function upload($uploadedFile, $folder = null, $disk = 'public', $filename = null)
    {
        $name = !is_null($filename) ? $filename : Str::random(25);
        (!\File::isDirectory(storage_path('app/public/'.$folder))) ?  \File::makeDirectory(storage_path('app/public/'.$folder), 0777, true, true) : '';
        $file = $uploadedFile->storeAs($folder, $name.'.'.$uploadedFile->getClientOriginalExtension(), $disk);
        
        $destinationPath = public_path('/storage//'.$folder);
        if (!file_exists($destinationPath)) {
            //create folder
            mkdir($destinationPath, 0755, true);
        }
        $uploadedFile->move($destinationPath, $name.'.'.$uploadedFile->getClientOriginalExtension());
        
        
        return $file;
    }

    function generateCodeEmail($length = 0) 
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    function generateCodePhone($length = 0) 
    {
        $numbers = '0123456789';
        $charactersLength = strlen($numbers);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $numbers[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
