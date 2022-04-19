<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\{
    Booking,
    QuoteBooking,
    Operator
};
use App\Notifications\QuotationEvents;
use App\Notifications\BookingEvents;
use DB;
use App\Chat\Soachat;
use Mail;
use App\User;

class QuotationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:operators')->except('logout');
    }


    public function index()
    {
        
        $title = "Quotation Requests";
        $op = auth()->user();
        
        $minibus = $op->minibus[0];

        $bookings = "";
        if(isset($op->latitude) && isset($op->latitude)){
            $bookings_data = Booking::whereStatus(0)->get();
            if($minibus->type==3){
                foreach($bookings_data as $key => $row){
               
                $bookings = DB::select("SELECT b.*, ( 3959 * acos( cos( radians(b.pickup_lat) ) * cos( radians( ".$op->latitude." ) ) * cos( radians( ".$op->longitude." ) - radians(b.pickup_long) ) + sin( radians(b.pickup_lat) ) * sin( radians( ".$op->latitude." ) ) ) ) AS distance 
                FROM bookings b 
                LEFT JOIN quote_bookings qb on b.id=qb.booking_id
                WHERE qb.id IS NULL OR qb.status=0 
                HAVING distance < 100 
                and b.status = 0 ");
            }
            }else{
                foreach($bookings_data as $key => $row){
               
                $bookings = DB::select("SELECT b.*, ( 3959 * acos( cos( radians(b.pickup_lat) ) * cos( radians( ".$op->latitude." ) ) * cos( radians( ".$op->longitude." ) - radians(b.pickup_long) ) + sin( radians(b.pickup_lat) ) * sin( radians( ".$op->latitude." ) ) ) ) AS distance 
                FROM bookings b
                LEFT JOIN quote_bookings qb on b.id=qb.booking_id
                WHERE qb.id IS NULL OR qb.status=0 
                HAVING distance < 100 
                and b.status = 0 and no_of_passengers <=".$minibus->capacity." and (CASE
                                                                                                                        WHEN b.type=1 THEN b.type=".$minibus->type."
                                                                                                                        WHEN b.type=2 THEN b.type=".$minibus->type."
                                                                                                                        END
                                                                                                                       )");
            }
            }
            
        }
        
        
        return view('operators.quotes.index', compact('title', 'bookings'));
    }

    public function show($id)
    {
        $booking = Booking::with('user', 'quotes')->find($id);
        return view('operators.quotes.details', compact('booking'));
    }

    public function sendQuotation(Request $request)
    {
         $request->validate([
            'amount' => ['required'],
        ]);
        $operator = Operator::find(auth()->user()->id);
        if($operator->quotations > 0){
            $booking = Booking::find($request->booking_id);
            if($booking){
                $quote = new QuoteBooking();
                $quote->operator_id = \Auth::user()->id;
                $quote->booking_id = $booking->id;
                $quote->amount = $request->amount;
                $quote->save();
               
                if($quote){
                     $user = User::find($booking->user_id);
                     //add soa chat friend
                    Soachat::addFriends($operator->uuid, $user->uuid);
                    
                    $operator->quotations = $operator->quotations - 1;
                    $operator->save();
                    
                    // try{
                    //     Mail::raw("Operator will now confirm bookings.', 'Trip#'.$booking->id", function ($message) use($user) {
                    //         $message->to($user->email)
                    //             ->subject('Your trip status - MINIBUS -  ')->from('richardsteve979@gmail.com');
                    //     });
                    // }
                    // catch(\Exception $e){
                    //     // Get error here
                    // }
                   
                   // $operator->notify(new QuotationEvents($quote));
                    $booking->user->notify(new BookingEvents($quote, $operator));
                return response()->json(['status'=>true, 'message' => 'Quotation sent successfully'], 200);
                }
            }
        }else{
            return response()->json(['status'=>false,'message' => 'You are unable to send quotation, Please Top up your wallet.'], 200);
        }
        
    }

    
    
    
}
