<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\{
    QuoteBooking
};

class QuotationSentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:operators')->except('logout');
    }

    public function index()
    {
        $title = "Quotation Sent";
        $quotes = QuoteBooking::with('booking')->join('bookings', 'bookings.id', '=', 'quote_bookings.booking_id')
                ->where('quote_bookings.operator_id', auth()->user()->id)
                ->where('quote_bookings.status',0)
                ->where('bookings.status', 0)
                ->get();
        $confirmed = QuoteBooking::with('booking')->join('bookings', 'bookings.id', '=', 'quote_bookings.booking_id')
                    ->where('quote_bookings.operator_id', auth()->user()->id)
                    ->whereIn('bookings.status', [0,1])
                    ->where('quote_bookings.status',1)
                    //->where('bookings.status', 1)
                    ->get();
        $rejected = QuoteBooking::with('booking')->where('operator_id', auth()->user()->id)->whereStatus(2)->get();
   
        return view('operators.sent.index', compact('title','quotes', 'confirmed', 'rejected'));
    }

    public function sent($id)
    {
        $title = "";
        $quote = QuoteBooking::with('booking.user')->where('booking_id',$id)->first();
        return view('operators.sent.recently-sent', compact('title','quote'));
    }

    public function confirmed($id)
    {
         $title = "";
        $quote = QuoteBooking::with('booking', 'operator')->where('booking_id',$id)->first();
        return view('operators.sent.awaiting-confirm', compact('title','quote'));
    }

    public function rejected($id)
    {
         $title = "";
        $quote = QuoteBooking::with('booking')->find($id);
        return view('operators.sent.declined', compact('title','quote'));
    }
}
