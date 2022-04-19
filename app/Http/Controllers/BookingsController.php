<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{
    Booking,
    Operator,
    QuoteBooking,
    PaymentLog,
    SpecialInvite,
    ComplainCategory,
    Complain,
    Admin,
    OperatorRating
};
use App\Http\Requests\BookingRequest;
use DB, Session, Validator, Stripe, DateTime;
use App\Notifications\{
    BookingTrip,
    QuotationEvents,
    BookingEvents,
    BookingStatuses,
    OperatorBookingStatuses,
    SpecialInviteNotification,
    AdminNotification,
    OperatorNotification
};
use Carbon\Carbon;
use App\Chat\Soachat;
use Mail;

class BookingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('web')->except('logout');
    }

    public function index()
    {

        $id = \Auth::user()->id;
       
        $bookings = Booking::where('user_id', $id)->whereStatus(0)->orderBy('id', 'desc')->get();
        $accepted = Booking::with('quote')->where('user_id', $id)->whereStatus(1)->orderBy('id', 'desc')->get();
        $confirmed = Booking::where('user_id', $id)->whereStatus(2)->orderBy('id', 'desc')->get();
        $ongoing = Booking::where('user_id', $id)->whereStatus(3)->orderBy('id', 'desc')->get();
        $completed = Booking::where('user_id', $id)->whereStatus(4)->orderBy('id', 'desc')->get();
        $cancelled = Booking::where('user_id', $id)->whereIn('status', [5,6])->orderBy('id', 'desc')->get();
        
        return view('user.bookings.my_bookings', compact('bookings', 'accepted', 'confirmed', 'ongoing', 'completed', 'cancelled'));
    }
  
   public function bookTrip()
   {
        $trip_details = \Session::get('trip_details');
        if(isset($trip_details) && $trip_details != NULL){
            return view('user.bookings.book_trip', compact('trip_details'));
        }else{
            return redirect('/');
        }
            
   }

   public function show($id)
   {
        $booking = Booking::with('quotes')->find($id);
        $special_invite = SpecialInvite::where('user_id', $booking->user_id)->where('operator_id', $booking->operator_id)->where('booking_id', $booking->booking_id)->get();
        $now = new DateTime();

     //   $future_date = new DateTime($booking->pickup_date.' '.$booking->pickup_time);

        $future_date = new DateTime($booking->pickup_date);
        $interval = $future_date->diff($now);
        //dd($future_date->format('Y'));
        $days_left = $interval->days;
        $time_left = $interval->format("%a days, %h hours, %i minutes, %s seconds");
        return view('user.bookings.details', compact('booking', 'special_invite', 'time_left', 'days_left', 'future_date'));
   }

   public function accepted($id){
        $check = PaymentLog::where('user_id', auth()->user()->id )->where('booking_id', $id)->first();
        $paid = isset($check) ? 1 : 0;
        $quote = QuoteBooking::with('booking', 'operator')->where('booking_id', $id)->first();
        $security_deposit = 0.3 * $quote->amount;
       
        return view('user.bookings.accept', compact('quote', 'security_deposit', 'paid'));
   }

  public function confirmed($id)
   {

        $check = PaymentLog::where('user_id', auth()->user()->id )->where('booking_id', $id)->first();
        $paid = isset($check) ? 1 : 0;
        $quote = QuoteBooking::with('booking', 'operator')->where('booking_id', $id)->first();
        $security_deposit = 0.3 * ($quote->amount ?? 0);
      
        //$future_date = new DateTime(Carbon::parse($quote->booking->pickup_date)->format('Y-m-d').' '.$quote->booking->pickup_time);
        $future_date = new DateTime(Carbon::parse($quote->booking->pickup_date)->format('Y-m-d'));
        return view('user.bookings.confirmed', compact('quote', 'security_deposit', 'future_date', 'paid','check'));
    }

    public function ongoing($id)
    {
        $quote = QuoteBooking::with('booking', 'operator')->where('booking_id', $id)->first();
        $categories = ComplainCategory::get();
        $security_deposit = 0.3 * $quote->amount;
      //  $future_date = new DateTime(Carbon::parse($quote->booking->pickup_date)->format('Y-m-d').' '.$quote->booking->pickup_time);
        $future_date = new DateTime(Carbon::parse($quote->booking->pickup_date)->format('Y-m-d'));
        return view('user.bookings.ongoing', compact('quote', 'categories', 'security_deposit', 'future_date'));
    }

    public function completed($id)
    {
        $quote = QuoteBooking::with('booking', 'operator')->where('booking_id', $id)->first();
        $check = OperatorRating::where('booking_id', $id)->get();
        $security_deposit = 0.3 * $quote->amount;
        if(count($check) < 1){
            $isRate = 0;
        }else{
            $isRate = 1;
        }
       
        
        return view('user.bookings.completed', compact('quote', 'isRate', 'security_deposit'));
    }

    public function cancelled($id)
    {
        $quote = QuoteBooking::with('booking', 'operator')->where('booking_id', $id)->first();
   
        return view('user.bookings.cancelled', compact('quote'));
    }

   public function cancel(Request $request)
   {
       $booking_id = QuoteBooking::with('operator')->where('booking_id',$request->id)->first();
        $operator_email = $booking_id->operator->email;
       $booking = Booking::find($request->id);

       if($booking){
        $booking->status = 5;
        $booking->save();
        
        $quote = QuoteBooking::with('booking')->where('booking_id', $booking->id)->first();  //Notification
        try{
            Mail::raw("Trip Cancel', 'Trip#'.$booking->id.' has been cancelled by user", function ($message) use($operator_email) {
                $message->to(['admin@minibuscomparison.co.uk', $operator_email])
                    ->subject('USER TRIP CANCELATION - MINIBUS -  ')->from('richardsteve979@gmail.com');
            });
        } catch (\Exception $e){
            
        }    
        
        // $quote->operator->notify(new OperatorBookingStatuses($quote, 0));
        // $booking->user->notify(new BookingStatuses($quote, 0));
        \Notification::send(Admin::all(), new AdminNotification('Trip Cancel', 'Trip#'.$booking->id.' has been cancelled by user', 'quotations'));
        return response()->json(['message' => 'Booking cancelled successfully'], 200);
       }
       else{
        return response()->json(['error' => 'Cannot perform action.'], 422);
       }
   }

   public function store(Request $request)
   {
     
     $rules = [
         "pickup_date" => "required",
         "pickup_time" => "required",
         "hand_luggage" => "required",
         "mid_luggage" => "required",
         "large_luggage" => "required",
         "trip_reason" => "required",
         "contact_name" => "required",
         "contact_email" => "required",
         "contact_phone" => "required|min:8"
     ];
     $customAttributes = [
        "pickup_date" => "PickUp Date",
        "pickup_time" => "PickUp Time",
        "hand_luggage" => "Hand Luggage",
        "mid_luggage" => "Medium Luggage",
        "large_luggage" => "Large Luggage",
        "trip_reason" => "Trip Reason",
        "contact_name" => "Contact Name",
        "contact_email" => "Contact Email",
        "contact_phone" => "Contact Phone"
     ];
     if(isset($request->is_return) && $request->is_return == true){
        $rules['return_date']          = "required";
        $rules['return_time']          = "required";
        $rules['return_address']       = "required";

        $customAttributes['return_date']          = "Return Date";
        $customAttributes['return_time']          = "Return Time";
        $customAttributes['return_address']       = "Return Address";
     }
     

     $validator = \Validator::make($request->all(), $rules, [], $customAttributes);

     if($validator->fails()) {
        // return redirect('/bookings/trip')->withErrors($validator);
       return redirect()->back()->withInput($request->all())->withErrors($validator);
     }

    // $type = implode(',', $request->type);
   
     $pickup = explode(',', $request->pickup);  
     $dropoff = explode(',', $request->dropoff);
     if(isset($request->is_return) && $request->is_return == true){
        $return = explode(',', $request->return);
     }
     

     DB::beginTransaction();
     try{
         $booking = new Booking();
         $booking->user_id = $request->user_id;
         $booking->no_of_passengers = $request->passengers;
         $booking->type =$request->type;
         $booking->pickup_date = date("Y-m-d", strtotime($request->pickup_date)) ;
         $booking->pickup_time = $request->pickup_time;
         $booking->pickup_lat = $pickup[0];
         $booking->pickup_long = $pickup[1];
         $booking->pickup_address = $request->pickup_address;
         if(isset($request->return) && $request->is_return == true){
            $booking->return_date = date("Y-m-d", strtotime($request->return_date));
            $booking->return_time = $request->return_time;
            $booking->return_lat = $return[0];
            $booking->return_long = $return[1];
            $booking->return_address = $request->return_address;
         }
         $booking->dropoff_lat = $dropoff[0];
         $booking->dropoff_long = $dropoff[1];
         $booking->dropoff_address = $request->dropoff_address;
         $booking->is_return = $request->is_return;
         $booking->trip_reason = $request->trip_reason;
         $booking->hand_luggage = $request->hand_luggage;
         $booking->mid_luggage = $request->mid_luggage;
         $booking->large_luggage = $request->large_luggage;
         $booking->additional_info = $request->additional_info;
         $booking->contact_name = $request->contact_name;
         $booking->contact_email = $request->contact_email;
         $booking->contact_phone = $request->contact_phone;
         $booking->save();


        $upper_latitude = $pickup[0] + (.5); //Change .5 to small values
        $lower_latitude = $pickup[0] - (.5); //Change .5 to small values
        $upper_longitude = $pickup[1] + (.5); //Change .5 to small values
        $lower_longitude = $pickup[1] - (.5); //Change .5 to small values 


            // $result = \DB::table('operators')
            // ->whereBetween('operators.latitude', [$lower_latitude, $upper_latitude])
            // ->whereBetween('operators.longitude', [$lower_longitude, $upper_longitude])
            // ->get();

        // $bookings = \DB::select("SELECT b.*, ( 3959 * acos( cos( radians(b.pickup_lat) ) * cos( radians( " . $op->latitude . " ) ) * cos( radians( " . $op->longitude . " ) - radians(b.pickup_long) ) + sin( radians(b.pickup_lat) ) * sin( radians( " . $op->latitude . " ) ) ) ) AS distance 
        //     FROM bookings b 
        //     LEFT JOIN quote_bookings qb on b.id=qb.booking_id
        //     WHERE qb.id IS NULL OR qb.status=0 
        //     HAVING distance < 100 
        //     and b.status = 0 ");


        $operators_email =
            \DB::table("operators")
            ->select("operators.id", "operators.email", \DB::raw("3959 * acos(cos(radians(" . $pickup[0] . "))
        * cos(radians(operators.latitude)) 
        * cos(radians(operators.longitude) - radians(" . $pickup[1] . ")) 
        + sin(radians(" . $pickup[0] . ")) 
        * sin(radians(operators.latitude))) AS distance"))
            ->having('distance', '<', 100)
            ->get();

        $send_emails = array();
        foreach ($operators_email as $item) {
            $send_emails[] = $item->email;
        }
        
         $send_emails;

        try{
            dispatch(new \App\Jobs\SendEmailJob($send_emails));
        }catch(\Exception $e){
            
        }

        // try {
        //     Mail::raw("Trip Create', 'Trip# has been Create by user", function ($message) use ($emails) {
        //         $message->to($emails)
        //             ->subject('USER TRIP Created - MINIBUS -  ')->from('richardsteve979@gmail.com');
        //     });
        //     // return "its work";
        // } catch (\Exception $e) {
        // }

         try {
               auth()->user()->notify(new BookingTrip($booking));
                \Notification::send(Admin::all(), new AdminNotification('Trip Booked', 'A new trip has been booked', 'quotations'));

         } catch (\Exception $e) {
            session()->forget('trip_details');
             return view('user.bookings.confirm_trip');
         }

         
         DB::commit();
     }catch( \Exception $e){
         DB::rollback();
         return $e->getMessage();

     }
     session()->forget('trip_details');
     //Session::flash('message', 'Booking request saved successfully!');
     return view('user.bookings.confirm_trip');
        
   }

   public function addPayment(Request $request)
   {
        $request->validate([
            'name' => ['required'],
            'card_number' => 'required|min:16|max:16',
            'cvv' => 'required|min:3|max:3',
            'expiry' => ['required'],
        ]);
         
        $quote = QuoteBooking::with('booking')->find($request->id);
        Stripe\Stripe::setApiKey('sk_test_oYPKmNstUifUQynm2tNMvSfR');
         $charge  = Stripe\Charge::create ([
                "amount" => $request->amount * 100,
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "Test payment" 
        ]);
        if(isset($charge)){
            $payment = PaymentLog::insert([
                'user_id'=> auth()->user()->id,
                'booking_quote_id'=> $quote->id,
                'booking_id'=> $quote->booking_id,
                'operator_id'=> $quote->operator_id,
                'amount'=> $request->amount,
                'stripe_charge_id'=> $charge->id,
                'details'=> json_encode($charge),
                'created_at'=> date('Y-m-d'),
            ]);

            $quote->status = 2;
            $quote->save();

            Booking::find($quote->booking_id)->update(['security_deposit' => $request->amount,'is_paid'=>1]);

            $quote->operator->notify(new OperatorBookingStatuses($quote, $request->amount));
            auth()->user()->notify(new BookingStatuses($quote, $request->amount));
            //Notification::send(Admin::all(), new AdminNotification('Booking - Payment', 'Security deposit has been paid', 'payments'));

            return response()->json(['message' => 'Quotation confirmed successfully'], 200);
        }
    
   }

   public function specialInvite($id, Request $request)
   {
      
        $booking = Booking::find($id);

        if($request->filled('page')){
             if($booking->type==3){
                 
                 $operators = DB::select("SELECT DISTINCT op.*, om.capacity, om.type, ( 3959 * acos( cos( radians(".$booking->pickup_lat.") ) * cos( radians( op.latitude ) ) * cos( radians( op.longitude ) - radians(".$booking->pickup_long.") ) + sin( radians(".$booking->pickup_lat.") ) * sin( radians( op.latitude ) ) ) ) AS distance FROM operators op LEFT JOIN operators_minibuses AS om ON om.operator_id=op.id HAVING distance < 500 and om.capacity>=".$booking->no_of_passengers." ORDER BY op.id DESC LIMIT ".$request->page.",".$request->page."");
             }else{
                 $operators = DB::select("SELECT DISTINCT op.*, om.capacity, om.type, ( 3959 * acos( cos( radians(".$booking->pickup_lat.") ) * cos( radians( op.latitude ) ) * cos( radians( op.longitude ) - radians(".$booking->pickup_long.") ) + sin( radians(".$booking->pickup_lat.") ) * sin( radians( op.latitude ) ) ) ) AS distance FROM operators op LEFT JOIN operators_minibuses AS om ON om.operator_id=op.id HAVING distance < 500 and om.capacity>=".$booking->no_of_passengers." and (CASE
                        WHEN om.type=1 THEN om.type=".$booking->type."
                        WHEN om.type=2 THEN om.type=".$booking->type."
                        END
                       ) ORDER BY op.id DESC LIMIT ".$request->page.",".$request->page."");
             }
           

            return response()->json($operators);
        }else{
           if($booking->type==3){
               
                  
            $operators = DB::select("SELECT DISTINCT op.*,om.capacity, om.type, ( 3959 * acos( cos( radians(".$booking->pickup_lat.") ) * cos( radians( op.latitude ) ) * cos( radians( op.longitude ) - radians(".$booking->pickup_long.") ) + sin( radians(".$booking->pickup_lat.") ) * sin( radians( op.latitude ) ) ) ) AS distance FROM operators op LEFT JOIN operators_minibuses AS om ON om.operator_id=op.id HAVING distance < 500 and om.capacity>=".$booking->no_of_passengers."  ORDER BY op.id DESC LIMIT 0,5");
             //dd($operators);
           }else{
            $operators = DB::select("SELECT DISTINCT op.*,om.capacity, om.type, ( 3959 * acos( cos( radians(".$booking->pickup_lat.") ) * cos( radians( op.latitude ) ) * cos( radians( op.longitude ) - radians(".$booking->pickup_long.") ) + sin( radians(".$booking->pickup_lat.") ) * sin( radians( op.latitude ) ) ) ) AS distance FROM operators op LEFT JOIN operators_minibuses AS om ON om.operator_id=op.id HAVING distance < 500 and om.capacity>=".$booking->no_of_passengers." and 
                (CASE
                        WHEN om.type=1 THEN om.type=".$booking->type."
                        WHEN om.type=2 THEN om.type=".$booking->type."
                        END
                       ) 
                ORDER BY op.id DESC LIMIT 0,5");
           }
                       //$operators = Operator::get();
                       //dd($operators);

            
        return view('user.bookings.special_invite', compact('operators', 'booking'));
        }
        
   }

   public function sendSpecialInvite(Request $request)
   {
       $user_id = auth()->user()->id;
       $check = SpecialInvite::where('user_id', $user_id)->where('operator_id', $request->operator_id)->where('booking_id', $request->booking_id)->first();
       if(!$check){
        $special_invite = new SpecialInvite;
        $special_invite->user_id = $user_id;
        $special_invite->operator_id = $request->operator_id;
        $special_invite->booking_id = $request->booking_id;
        $special_invite->save();

        $user = \Auth::user();
        $operator = \App\Operator::find($request->operator_id);
        
        //add soa chat friend
        Soachat::addFriends($user->uuid, $operator->uuid);

        $operator->notify(new SpecialInviteNotification($user, $request->booking_id));
     //   Notification::send(Admin::all(), new AdminNotification('Special Invite', 'A new special invitation sent'));

        return response()->json(['message' => 'Special Invite sent to the operator successfully'], 200);
        
       }else{
        return response()->json(['error' => 'Request Already Sent'], 422);
       }
        
        
   }

   public function changeQuoteStatus(Request $request)
   {
     //  dd($request->all());
        $quote = QuoteBooking::find($request->quote_id);
        if(isset($quote)){
             if($request->status == 1){
                 $booking = Booking::find($quote->booking_id)->update(['status'=> 1]);
             }
            $quote->status = $request->status;
            $quote->save();

            $others = QuoteBooking::where('booking_id', $quote->booking_id)->whereStatus(0)->update(['status'=>2]);

            $quote->operator->notify(new QuotationEvents($quote));
            auth()->user()->notify(new BookingEvents($quote, $quote->operator));
            
            return response()->json(['success' => ($request->status==1 ? 'Quotation accepted successfully' : 'Quotation rejected successfully')], 200);

        }else{
            return response()->json(['error' => 'Cannot perform specified operation'], 422);
        }
   }

   public function report(Request $request)
   {
        $request->validate([
            'comments' => ['required'],
        ]);
        $complain = new Complain();
        $complain->complain_category_id = $request->category;  
        $complain->user_id = auth()->user()->id;  
        $complain->booking_id = $request->booking_id;  
        $complain->operator_id = $request->operator_id;  
        $complain->comments = $request->comments;  
        $complain->save();
        
        \Notification::send(Admin::all(), new AdminNotification('Operator Reported', 'A new report has been submitted against operator', 'feedbacks'));

        if($complain){
            return response()->json(['success' => 'Operator reported successfully'], 200);
        }else{
            return response()->json(['error' => 'Cannot perform specified operation'], 422);
        }
   }
   
   public function rateOperator(Request $request)
   {
      // dd($request->all());
        $request->validate([
            'comments' => ['required'],
            'rating' => ['min:1']
        ]);
        $rating = new OperatorRating();  
        $rating->user_id = auth()->user()->id;  
        $rating->booking_id = $request->booking_id;  
        $rating->operator_id = $request->operator_id;  
        $rating->comments = $request->comments;  
        $rating->rating = $request->rating;  
        $rating->save();

        $operator = Operator::find($request->operator_id);
        $message = auth()->user()->name.' has send you reviews';

        $operator->notify(new OperatorNotification($message, 'rate'));
        
        //Notification::send(Admin::all(), new AdminNotification('Operator Rating', 'A new report has been submitted'));

        if($rating){
            return response()->json(['success' => 'Operator rating added successfully'], 200);
        }else{
            return response()->json(['status' => false], 422);
        }
   }
  
}
