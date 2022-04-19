<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session, Redirect;
use App\{
    Booking,
    User,
    Feedback,
    PaymentLog,
    OperatorRating,
    Operator
};
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('web')->except('logout');
    }
    
    public function index(){
        return view('user.bookings');
    }

    

    public function getQuote(Request $request)
    {
        $rules = [
            "passengers" => "required|max:50",
            "pickup" => "required",
            "dropoff" => "required",
            "type" => "required",
            
        ];
        $customAttributes = [
            'pickup' => 'pickup location',
            'dropoff' => 'dropoff location',
            'type' => 'Option',
        ];

        $validator = \Validator::make($request->all(), $rules, [], $customAttributes);

        if($validator->fails()) {
            return redirect('/')->withErrors($validator)->withInput();
        }
      
        $option = (sizeof($request->type) == 2) ? 3 : $request->type[0];
     //   dd($option);
        Session::put('trip_details', 
        [
                'passengers'=>$request->passengers,
                'pickup'=>$request->pickup,
                'pickup_location'=>$request->pickup_location,
                'dropoff'=>$request->dropoff,
                'dropoff_location'=>$request->dropoff_location,
                'type'=> $option,
            ]);

        return Redirect::route('bookings.trip');

    }

    public function myBookings(){
        $id = \Auth::user()->id;
        $bookings = Booking::where('user_id', $id)->orderBy('id', 'desc')->get();
        
        return view('user.bookings.my_bookings', compact('bookings'));
    }

    public function view(){
        $id = \Auth::user()->id;
        $user = User::find($id);
        
        return view('user.profile.view', compact('user'));
    }

    public function edit(){
        $id = \Auth::user()->id;
        $user = User::find($id);
        
        return view('user.profile.edit', compact('user'));
    }

    public function update(Request $request){
       
        $request->validate([
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required',
            'phone_no' => 'required',
            'address' => 'required',
            // 'country' => 'required',
            // 'city' => 'required',
            // 'zipcode' => 'required'
        ]);
       
        try{
           
            $id = \Auth::user()->id;
            $user = User::findOrFail($id);
            if($user){
               
                if($request->file('file')){
                    $path = 'users/'.md5($user->id).'/minibus/';
                    $image = self::upload($request->file('file'), $path, 'public', null);
                   
                }
            
                $user->name = $request->name;   
                $user->surname = $request->surname;
                $user->email = $request->email;
                $user->phone_no = $request->phone_no;
                $user->address = $request->address;
                $user->country = $request->country; 
                $user->city = $request->city;
                $user->state = $request->state;
                $user->zipcode = $request->zipcode;
                $user->image = isset($image) ? $image : "";  
                $user->save();
                Session::flash('message', 'Updated Successfully.');

            }
               

        }catch( \Exception $e){
            Session::flash('error', 'Unable to update! Please check the given data.');
        }
        return redirect('/profile');
    }

    public function updatePassword(Request $request){
        $id = \Auth::user()->id;
        $this->validate($request, [
            'old_password'     => 'required',
            'new_password'     => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        ]);
     
        $data = $request->all();
      
        $user = User::find(auth()->user()->id);
     
        if(!\Hash::check($data['old_password'], $user->password)){
             return response()->json(['error' => 'You have entered wrong current password'], 200);
     
        }else{
     
           $update = User::where('id', $id)->update([
               'password'=> Hash::make($request->new_password)
           ]);
           return response()->json(['msg' => 'Pasword updated successfully'], 200);
     
        }
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

    
    public function paymentLogs()
    {
        $payment_logs = PaymentLog::with('user', 'booking', 'operator', 'quote')->where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->get();
        return view('user.payment-log', compact('payment_logs'));
    }

    public function addReview(Request $request){
        $request->validate([
            'review' => 'required'
        ]);
        try{
        $feedback = new OperatorRating;
        $feedback->user_id = auth()->user()->id;
        $feedback->operator_id = $request->operator_id;
        $feedback->comments = $request->review;
        $feedback->save();
       
        Session::flash('message', 'Review has been added successfully.');

        }catch( \Exception $e){
            Session::flash('error', 'Unable to send! Please check the given data.');
        }
        return redirect()->back();

    }

    public function chat($id){
        //update message counter to 0
        $user = \Auth::user();
        $update = User::where('id',$user->id)->update(['notification_count' => 0]);
        
       $operator_id = $id;
        return view('user.chat', compact('operator_id'));
    }
    public function updateNotificationCount(Request $request){
        $user = User::where('uuid',$request->receipant_id)->first();
        if($user){
            $user->notification_count += 1;
            $user->save();
            return response()->json(['status' => true,'message' => 'notification counter updated successfully']);
        }
        $user = Operator::where('uuid',$request->receipant_id)->first();
        if($user){
            $user->notification_count += 1;
            $user->save();
            return response()->json(['status' => true,'message' => 'notification counter updated successfully']);

        }
        
    }
    public function getMessageCount(){
        $user = \Auth::user();
        return $user->notification_count;
    }
    
}
