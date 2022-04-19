<?php

namespace App\Http\Controllers\Operator\Auth;

use App\Http\Controllers\Controller;
use App\Operator;
use App\TempMedia;
use App\Models\Operator\Minibus;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
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
    protected $redirectTo = '/operators';

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
            'address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string'],
            'phone' => ['required', 'string', 'max:15'],
        ]);
    }

    public function registerOperator(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'company_name' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:operators'],
            'address' => ['required', 'string'],
           // 'drivers_license' => ['required', 'string'],
            'city' => ['required', 'string'],
            'phone' => ['required', 'string', 'min:8'],
            'country' => ['required', 'string'],
            'zipcode' => ['required', 'string'],
            'op_latitude' => 'required',
            'op_longitude' => 'required',

        ],[
            'zipcode.required' => "Postal Code field is required.",
            'op_latitude.required' => 'address field should be filled using geo location search engine',
        ]);
       
        if(isset($request['file']) && $request['file'] !== 'undefined'){
            $path = 'operator/'.md5($request['phone']).'/minibus/';
            $image = self::upload($request->file('file'), $path, 'public', null);
        }
        $code = $this->generateCodePhone(4);
        Session::put('operator_data', 
        [
            'name' => $request['name'],
            'company_name' => $request['company_name'],
            'email' => $request['email'],
            'address' => $request['address'],
            'op_latitude' => $request['op_latitude'],
            'op_longitude' => $request['op_longitude'],
            'city' => $request['city'],
            'country' => $request['country'],
            'state' => $request['state'],
            'zipcode' => $request['zipcode'],
            'phone' => $request['phone'],
            'drivers_license' => $request['drivers_license'],
            'aboutme' => $request['aboutme'],
            'auth_code_phone' => $code,
            'auth_code_email' => $this->generateCodeEmail(8),
            'image' => $image ?? ""
        ]);

        $accountSid = config('app.twilio')['TWILIO_ACCOUNT_SID'];
        $authToken  = config('app.twilio')['TWILIO_AUTH_TOKEN'];
        $client = new Client($accountSid, $authToken);
        try
        {
            $client->messages->create('+44'.$request['phone'],
            array(
                    'from' => '+18474534323',
                    'body' => 'Thanks for using Minibus. Your phone verification code is '.$code
                )
            );
        }
        catch (Exception $e)
        {
            //echo "Error: " . $e->getMessage();
                }

        
        $user_data = Session::get('operator_data');
        try{

            \Mail::to($request['email'])->send(new RegisterVerificationCode($user_data));
        }catch(\Exception $ex){
          return $ex;
        }
       
        
        return response()->json(['success'=>true, 'data'=>$user_data]);
    }

    public function minibus(Request $request)
    {
        $request->validate([
            'model' => ['required', 'string', 'max:50'],
            'capacity' => ['required', 'string'],
            'model' => ['required', 'string'],
            'type' => ['required', 'string'],
            'description' => ['required', 'string']
        ]);
       
        $user_data = Session::get('operator_data');

        if($request->files){
            foreach ($request->files as $key => $file){
                $image = '';
                $path = 'operator/'.md5(Str::random(10)).'/minibus//';
                $name = Str::random(25).'.'.$file->getClientOriginalExtension();
                $img_path =  (!\File::isDirectory(storage_path('app/public/'.$path))) ?  \File::makeDirectory(storage_path('app/public/'.$path), 0777, true, true) : '';
               
                // $file_path = $file->move(storage_path('app/public/'.$path), $name);
                $file_path = $file->move(public_path('/storage'."/".$path), $name);

                $temp = TempMedia::insert([
                    'identifier' => $request->model,
                    'path' => $path.$name
                ]);
              
            }
            
        }
       // Session::put('operator_minibus_images', $data['images']);
       
        Session::put('operator_minibus', 
        [
            'model' => $request['model'],
            'capacity' => $request['capacity'],
            'type' => $request['type'],
            'description' => $request['description'],
        ]);

        $minibus = Session::get('operator_minibus');
        
        return response()->json(['data'=>$user_data]);
    }

    public function verify(Request $request) 
    {
        $request->validate([
            'auth_code_phone' => ['required', 'string', 'min:4', 'max:4'],
            'auth_code_email' => ['required', 'string', 'min:8', 'max:8']
        ],[
            'auth_code_phone.required' => 'Phone verification code is required',
            'auth_code_phone.min' => 'Phone verification code should be atleast 4 digits',
            'auth_code_phone.max' => 'Phone verification code should be maximum 4 digits',
            'auth_code_email.required' => 'Email verification code is required',
            'auth_code_email.min' => 'Email verification code should be atleast 8 characters',
            'auth_code_email.max' => 'Email verification code should be maximum 8 characters'
        ]);

        $operator = Session::get('operator_data');
        
        if(($operator['auth_code_phone'] == $request->auth_code_phone) && ($operator['auth_code_email'] == $request->auth_code_email)){
            return response()->json([
                'status'=>true,
                'message'=> 'Account verified successfully'
            ], 200);
        }else{
            return response()->json([ 
                'status'=>false,
                'message'=> 'Invalid authentication code'], 200);
        }
    }

    public function setpassword(Request $request) 
    {
        
        $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:operators'],
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ]);

        $data = Session::get('operator_data');
        
        
        $operator = new Operator();
        $uuid = Str::uuid();

        $data['password'] = bcrypt($request['password']);
      //  $data['status'] = 1;
        $data['quotations'] = 20;
        $operator->fill($data);
        $operator->image = $data['image'] ?? '';
        $operator->latitude = $data['op_latitude'] ?? '';
        $operator->longitude = $data['op_longitude'] ?? '';
        $operator->phone_no = $data['phone'] ?? '';
        $operator->uuid = $uuid;
        $operator->save();
       
        $minibus_data = Session::get('operator_minibus');
        $minibus_images = TempMedia::where('identifier', $minibus_data['model'])->get();
         unset($minibus_images[0]);
        //dd($minibus_images);

        $minibus_data['operator_id'] = $operator->id;

        $minibus = Minibus::create($minibus_data);
        foreach($minibus_images as $image){
          
            $minibus->media()->save(new \App\Models\Media([
                'path'   => $image->path,
                'status' => 0,
                //'nature' => 'minibus'
            ]));
        }

        Soachat::addUser($operator->uuid, $operator->name, NULL, 0);
        try{
            $operator->notify(new UserRegistration('operator'));
            \Notification::send(Admin::all(), new AdminNotification('Operator Registered', 'A new operator has been registered on Minibus.', 'operators'));
        }catch(\Exception $ex){}
        
        //delete temp media
        TempMedia::where('identifier', $minibus_data['model'])->delete();
        // unset session
        Session::forget('operator_data');
        Session::forget('operator_minibus');

        return response()->json([
            'status'=>true,
            'message'=> 'Account registered successfully'
        ], 200);
        
    }

    public function resend() {
      
        $operator_data = Session::get('operator_data');

        $accountSid = config('app.twilio')['TWILIO_ACCOUNT_SID'];
        $authToken  = config('app.twilio')['TWILIO_AUTH_TOKEN'];
        $client = new Client($accountSid, $authToken);
        try
        {
            $client->messages->create(
            $operator_data['phone'],
            array(
                    'from' => '+18474534323',
                    'body' => 'Thanks for using Minibus. Your phone verification code is '.$operator_data['auth_code_phone']
                )
            );
        }
        catch (Exception $e)
        {
            //echo "Error: " . $e->getMessage();
        }

        try{
            \Mail::to($operator_data['email'])->send(new RegisterVerificationCode($operator_data));
        }catch(\Exception $ex){}
        
        return response()->json([
            'status'=>true,
            'message'=> 'Verification code sent. Please check your email and phone.'
        ], 200);
    }


    protected function register(Request $request)
    {
        $this->validator($request->all())->validate();
        
        event(new Registered($user = $this->create($request->all())));

        // $this->guard()->login($user);

       // return $this->registered($request, $user) ?: redirect($this->redirectPath());
       return true;
    }
   
    protected function create(array $data)
    {
        
       
        // $operator =  Operator::create([
        //     'name' => $data['name'],
        //     'email' => $data['email'],
        //     'password' => Hash::make($data['password']),
        //     'address' => $data['address'],
        //     'city' => $data['city'],
        //     'zipcode' => $data['zipcode'],
        //     'phone' => $data['phone'],
        //     'auth_code_phone' => $this->generateCodePhone(4),
        //     'auth_code_email' => $this->generateCodeEmail(8)
        // ]);
        
        // if(isset($data['file'])){
        //     $path = 'operator/'.md5($operator->id).'/minibus/';
        //     $image = self::upload($data['file'], $path, 'public', null);

        //     $operator->image = $image;
        //     $operator->save();
        // }
        
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
