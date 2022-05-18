<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\{
    Operator,
    Booking,
    QuoteBooking,
    PaymentLog,
    OperatorPaymentLog,
    OperatorRating,
    Feedback,
    User
};
use App\Models\Media;
use DB, Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Notifications\{
    BookingStatuses,
    OperatorBookingStatuses
};
use App\Models\Operator\Minibus;
use Mail;

class OperatorController extends Controller
{
    public function __construct()
    {
       // $this->middleware('auth');
    }

    public function index(){
        $id = auth('operators')->user()->id;
        $operator = Operator::with('minibus')->find($id);
        $buses = isset($operator->minibus[0]) ? $operator->minibus[0]->media : "";
        $reviews = OperatorRating::with('user')->where('operator_id', auth('operators')->user()->id)->orderBy('id', 'DESC')->get();
        return view('operators.profile.index', compact('operator', 'buses', 'reviews'));
    }

    public function edit(){
        $id = auth('operators')->user()->id;
        $operator = Operator::with('minibus')->find($id);
        $buses = isset($operator->minibus[0]) ? $operator->minibus[0]->media : "";
        
        return view('operators.profile.edit', compact('operator', 'buses'));
    }

    public function update(Request $request)
    { 
      //  dd($request->all());
        $rules = [
            "name" => "required",
            "company_name" => "required",
            "email" => "required",
            "phone_no" => "required",
            "address" => "required",
            "city" => "required",
            "state" => "required",
            "country" => "required",
            "zipcode" => "required"
        ];
        $customAttributes = [
           "name" => "Name",
           "company_name" => "Company Name",
           "email" => "Email",
           "phone_no" => "Phone Number",
           "address" => "Address",
           "city" => "City",
           "state" => "County",
           "country" => "Country",
           "zipcode" => "Postal code"
        ];
   
        $validator = \Validator::make($request->all(), $rules, [], $customAttributes);
   
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        // DB::beginTransaction();
        // try{
           
            $operator = Operator::findOrFail($request->id);
            if($request->image){
                $path = 'operator/'.md5($operator->id).'/minibus/';
                $image = Operator::upload($request->file('image'), $path, 'public', null);
            }
           
            $fields = $request->only($operator->getFillable());
           
            $operator->update($fields);
           
            if(isset($image)){
                $operator->image = $image;
                $operator->save();
            }
        
            $this->updateMinibus($request, $operator, $operator->minibus[0]->id);
            
        //    DB::commit();
        // }catch( \Exception $e){
        //     DB::rollback();

        //     return Session::flash('error', 'Operator cannot be updated');
        // }
       
        Session::flash('message', 'Operator updated successfully!');
        return redirect('operators');
    }

    public function updateMinibus($request, $operator, $minibus_id){
     //   dd($request->all());
        $minibus = Minibus::find($minibus_id);
        $minibus->model = $request->model;
        $minibus->capacity = $request->capacity;
        $minibus->type = $request->type;
        $minibus->description = $request->description;
       
        $minibus->save();
        if($request->file('files')){
            foreach ($request->file('files') as $key => $file){
                $path = 'operator/'.md5($operator->id).'/minibus/';
                $image = Operator::upload($file, $path, 'public', null);
                $minibus->media()->save(new \App\Models\Media([
                    'path'   => $image,
                    'status' => 0,
                    //'nature' => 'minibus'
                ]));
            }
        }
    }

    public function deleteMinibusImage($id){
        $media = Media::find($id)->delete();
        return response()->json(['message' => 'Image deleted successfully'], 200);
    }


    public function updatePassword(Request $request){
        $id = auth('operators')->user()->id;
        $this->validate($request, [
            'old_password'     => 'required',
            'new_password'     => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        ]);
     
        $data = $request->all();
      
        $operator = Operator::find($id);
     
        if(!\Hash::check($data['old_password'], $operator->password)){
             return response()->json(['msg' => 'You have entered wrong password'], 200);
     
        }else{
     
           $update = Operator::where('id', $id)->update([
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

    public function changeTripStatus(Request $request)
    {

       // dd($request->all());
        $booking = Booking::find($request->id);
        if(isset($booking)){
            if($request->status == 4){
                $booking->trip_end_date = date("Y-m-d");
            }
            $booking->status = $request->status;
            $booking->save();
            $quote = QuoteBooking::with('booking')->where('booking_id', $booking->id)->first();
            
            if($request->status == 4){
                $message = 'This trip is marked as completed';
                $url='completed';
                auth()->user()->notify(new OperatorBookingStatuses($quote));
                $booking->user->notify(new BookingStatuses($quote, 0, $url));
            }else if($request->status == 3){
                $url='started';
                $message = 'This trip is marked as started';
                auth()->user()->notify(new OperatorBookingStatuses($quote));
                $booking->user->notify(new BookingStatuses($quote, 0, $url));
            }else if($request->status == 6){
                $url='cancelled';
                $message = 'This trip is marked as cancelled';
                try {
                    Mail::raw("Trip Cancel', 'Trip#'.$booking->id.' has been cancelled by user", function ($message)  {
                        $message->to(['admin@minibuscomparison.co.uk'])
                            ->subject('Operator TRIP CANCELATION - MINIBUS -  ')->from('richardsteve979@gmail.com');
                    });
                } catch (\Exception $e) {
                }    
                auth()->user()->notify(new OperatorBookingStatuses($quote));
                $booking->user->notify(new BookingStatuses($quote, 0, $url));
            }else if($request->status == 2){
                $url='confirmed';
                $message = 'Trip has been confirmed.';
                $booking->user->notify(new BookingStatuses($quote, 0, $url));
            } else{
                $message = 'Trip status updated successfully';
            }
            return response()->json(['success' => $message], 200);

        }else{
            return response()->json(['error' => 'Cannot perform specified operation'], 422);
        }
    }

    public function paymentLogs()
    {
        $payment_logs = PaymentLog::with('user', 'booking', 'quote')->where('operator_id', auth()->user()->id)->orderBy('id', 'DESC')->get();
        $total = PaymentLog::where('operator_id', auth()->user()->id)
                            ->join('bookings as b', 'payment_logs.booking_id', '=', 'b.id')
                            ->where('b.status', 4)
                            ->select(DB::raw("SUM(b.security_deposit) as total"))->pluck('total')->first();
       $net_total = $total-(0.1*$total);
       
        $records = PaymentLog::where('operator_id', auth()->user()->id)
                            ->join('bookings as b', 'payment_logs.booking_id', '=', 'b.id')
                            ->where('b.status', 4)
                            ->select(DB::raw("SUM(b.security_deposit) as count, MONTH(b.created_at) month"))
                            ->groupBy(DB::raw("year(b.created_at), MONTH(b.created_at)"))
                            ->get();

        $month = PaymentLog::where('operator_id', auth()->user()->id)
                            ->join('bookings as b', 'payment_logs.booking_id', '=', 'b.id')
                            ->where('b.status', 4)
                            ->select(DB::raw("Sum(b.security_deposit) as count"))
                            ->orderBy("b.created_at")
                            ->groupBy(DB::raw("month(b.created_at)"))
                            ->get()->toArray();
        $month = array_column($month, 'count');
      
        $months = collect(['', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']);

        $chartData = collect([]);

        for ($i = 1; $i <= 12; $i++){
            $std = new \stdClass();
            $std->key = $months[$i];
            $std->value = $records->where('month', $i)->sum('count');
            $chartData->push($std);
        }
        return view('operators.payment-logs.index', compact('payment_logs', 'net_total'))
        ->with('chartData',$chartData);
    }

    public function paymentLogDetails($id)
    {
        $payment_log = PaymentLog::with('booking', 'quote')->find($id);
        $paid = $payment_log->quote->amount - $payment_log->amount;

        
       
        return view('operators.payment-logs.show', compact('payment_log', 'paid'));
    }

    public function markReceived(Request $request)
    {
        $booking = Booking::find($request->id);
        if(isset($booking) && $request->status == 1){
            $booking->is_paid = 1;
            $booking->save();
            return response()->json(['success' => 'Marked received successfully'], 200);

        }else{
            $booking->is_paid = 2;
            $booking->save();
            return response()->json(['success' => 'Marked as not received.'], 200);
        }
    }

    public function quotationLogs()
    {
        $id = auth()->user()->id;
        $records = OperatorPaymentLog::
            select(DB::raw("Count(amount) as count, MONTH(created_at) month"))
            ->groupBy(DB::raw("year(created_at), MONTH(created_at)"))
            ->get();

        $month = OperatorPaymentLog::select(DB::raw("Count(amount) as count"))
                ->orderBy("created_at")
                ->groupBy(DB::raw("month(created_at)"))
                ->get()->toArray();
        $month = array_column($month, 'count');

        $payments = DB::select("SELECT (SELECT count(b.id) FROM bookings b INNER JOIN quote_bookings qb on qb.booking_id=b.id INNER JOIN operators op on op.id=qb.operator_id WHERE qb.operator_id=".$id.") as sent, (SELECT count(b.id) FROM bookings b INNER JOIN quote_bookings qb on qb.booking_id=b.id INNER JOIN operators op on op.id=qb.operator_id WHERE qb.operator_id=".$id." and qb.status = 0) as ignored,
        (SELECT count(b.id) FROM bookings b INNER JOIN quote_bookings qb on qb.booking_id=b.id INNER JOIN operators op on op.id=qb.operator_id WHERE qb.operator_id=".$id." and qb.status = 1) as accepted,
        (SELECT count(b.id) FROM bookings b INNER JOIN quote_bookings qb on qb.booking_id=b.id INNER JOIN operators op on op.id=qb.operator_id WHERE qb.operator_id=".$id." and qb.status = 2) as rejected,
        (SELECT count(b.id) FROM bookings b INNER JOIN quote_bookings qb on qb.booking_id=b.id INNER JOIN operators op on op.id=qb.operator_id WHERE qb.operator_id=".$id." and b.status = 6) as cancelled,
        (SELECT count(b.id) FROM bookings b INNER JOIN quote_bookings qb on qb.booking_id=b.id INNER JOIN operators op on op.id=qb.operator_id WHERE qb.operator_id=".$id." and b.status = 4) as completed,
        (SELECT quotations from operators where id=".$id.") as quotations");

        $months = collect(['', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']);

        $chartData = collect([]);

        for ($i = 1; $i <= 12; $i++){
            $std = new \stdClass();
            $std->key = $months[$i];
            $std->value = $records->where('month', $i)->sum('count');
            $chartData->push($std);
        }
        
        return view('operators.quotation-logs', compact('payments'))
        ->with('chartData',$chartData);
    }

    public function chat(){
        //update message counter to 0
        $user = \Auth::user();
        $update = Operator::where('id',$user->id)->update(['notification_count' => 0]);
         return view('operators.message');
     }

     public function customerChat($id){
        $user_id = $id;
         //update message counter to 0
        $user = \Auth::user();
        $update = Operator::where('id',$user->id)->update(['notification_count' => 0]);
         return view('operators.chat', compact('user_id'));
     }

     public function contact()
    {
        return view('operators.contact-us');
    }

    public function contactStore(Request $request)
    {
        $request->validate([
            'subject' => 'required',
            'email' => 'required',
            'message' => 'required'
        ]);
        try{
        $feedback = new Feedback;
        $feedback->type = 2;
        $feedback->user_id = auth()->user()->id ?? 0 ;
        $feedback->email = $request->email;
        $feedback->subject = $request->subject;
        $feedback->message = $request->message;
        $feedback->save();

        Session::flash('message', 'Your message has been sent successfully.');

        }catch( \Exception $e){
            Session::flash('error', 'Unable to send! Please check the given data.');
        }
        return redirect('/contact-us');

    }

    public function reviewReply(Request $request){
        // $validator = $request->validate([
        //     'reply' => 'required'
        // ]);
        // if($validator->fails()) {
        //     return Redirect::back()->withErrors($validator);
        // }
        $rating = OperatorRating::find($request->id);
        $rating->reply = $request->reply;
        $rating->save();
        Session::flash('message', 'Reply added successfully.');
        return redirect('/operators');
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
