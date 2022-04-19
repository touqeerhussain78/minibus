<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\{
    Booking,
    QuoteBooking,
    OperatorRating
};
use DateTime;

class QuotationAcceptedController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:operators')->except('logout');
    }

    public function index()
    {
        
        $title = "Quotations Accepted";
        $pending = QuoteBooking::join('bookings', 'bookings.id','=','quote_bookings.booking_id')
                    ->where('quote_bookings.operator_id', auth()->user()->id)->whereIn('bookings.status',[1,2])->get();
                   
        
        $started = QuoteBooking::join('bookings', 'bookings.id','=','quote_bookings.booking_id')
                   ->where('quote_bookings.operator_id', auth()->user()->id)->where('bookings.status',3)->get();

        $completed = QuoteBooking::join('bookings', 'bookings.id','=','quote_bookings.booking_id')
                    ->where('quote_bookings.operator_id', auth()->user()->id)->where('bookings.status',4)->get();

        $cancelled = QuoteBooking::join('bookings', 'bookings.id','=','quote_bookings.booking_id')
                    ->where('quote_bookings.operator_id', auth()->user()->id)->where('bookings.status',5)->get();

        $cancelled_by_you = QuoteBooking::join('bookings', 'bookings.id', '=', 'quote_bookings.booking_id')
        ->where('quote_bookings.operator_id', auth()->user()->id)->where('bookings.status', 6)->get();
       
        return view('operators.quote-accepted.index', compact('title','pending', 'started', 'completed', 'cancelled', 'cancelled_by_you'));
    }

    public function pending($id)
    {
        $quote = QuoteBooking::with('booking.user')->where('booking_id', $id)->first();
        $future_date = new DateTime($quote->booking->pickup_date);
        return view('operators.quote-accepted.pending', compact('quote', 'future_date'));
    }

    public function ongoing($id)
    {
        $quote = QuoteBooking::with('booking.user')->where('booking_id', $id)->first();
        $future_date = new DateTime($quote->booking->pickup_date);
        return view('operators.quote-accepted.ongoing', compact('quote', 'future_date'));
    }

   public function completed($id)
    {
        $quote = QuoteBooking::with('booking.user')->where('booking_id', $id)->first();
        $rating = OperatorRating::where(['booking_id' => $id, 'operator_id' => auth()->user()->id])->get();
        if(count($rating) < 1){
            $isRate = 0;
        }else{
            $isRate = 1;
        }
       
        return view('operators.quote-accepted.completed', compact('quote', 'isRate', 'rating'));
    }

    public function cancelled($id)
    {
        $quote = QuoteBooking::with('booking.user')->where('booking_id', $id)->first();
       
        return view('operators.quote-accepted.cancelled', compact('quote'));
    }
}
