<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\{
    Booking,
    QuoteBooking,
    User,
    Operator
};
use Carbon\Carbon;
use DB;
use App\Notifications\WalletNotification;

class QuotationsController extends Controller
{
    public function index(Request $request){
      
        $bookings = Booking::whereStatus(0);

        if ($request->filled('from') && $request->filled('to')) {
            $bookings->where(function ($query) use ($request) {
                $query->whereBetween('bookings.created_at', [$request->from, $request->to]);
            }); 
        }
        $bookings = $bookings->orderBy('id', 'desc')->get();

        $accepted = Booking::with('quotes')->whereStatus(1);
        if ($request->filled('start') && $request->filled('end')) {
            $accepted->where(function ($query) use ($request) {
                $query->whereBetween('bookings.created_at', [$request->start, $request->end]);
            }); 
        }
        $accepted = $accepted->orderBy('id', 'desc')->get();

        $confirmed = Booking::whereStatus(2);
        if ($request->filled('c_from') && $request->filled('c_to')) {
            $confirmed->where(function ($query) use ($request) {
                $query->whereBetween('bookings.created_at', [$request->c_from, $request->c_to]);
            }); 
        }
        $confirmed = $confirmed->orderBy('id', 'desc')->get();

        $ongoing = Booking::whereStatus(3)->orderBy('id', 'desc')->get();

        $completed = Booking::whereStatus(4);
        if ($request->filled('co_from') && $request->filled('co_to')) {
            $completed->where(function ($query) use ($request) {
                $query->whereBetween('bookings.created_at', [$request->co_from, $request->co_to]);
            }); 
        }
        $completed = $completed->orderBy('id', 'desc')->get();
        
        $cancelled = Booking::whereIn('status', [5,6]);
        if ($request->filled('cn_from') && $request->filled('cn_to')) {
            $cancelled->where(function ($query) use ($request) {
                $query->whereBetween('bookings.created_at', [$request->cn_from, $request->cn_to]);
            }); 
        }
        $cancelled = $cancelled->orderBy('id', 'desc')->get();

        return response()->json([
            'bookings'  => $bookings, 
            'accepted' => $accepted, 
            'confirmed' => $confirmed,  
            'ongoing' => $ongoing, 
            'completed' => $completed, 
            'cancelled' => $cancelled
            ]);
        
    }

    public function pending($id)
    {
        $booking = Booking::with('quotes')->find($id);
        $from = Carbon::parse($booking->pickup_date);
        $to = Carbon::now();
        $diff_in_days = $to->diffForHumans($from);
        $diff_in_hours = $to->diffInHours($from);
        return response()->json([
            'booking'  => $booking,
            'days_left' => $diff_in_days,
            'time_left' => $diff_in_hours
            ]);
    }

    public function accepted($id){
        $quote = QuoteBooking::with('booking', 'operator')->whereStatus(1)->where('booking_id', $id)->first();
       
        $amount_remaining = 0.7 * $quote->amount;
        return response()->json([
            'quote'  => $quote, 
            'security_deposit' => $amount_remaining
            ]);
   }

   public function confirmed($id)
   {
    $quote = QuoteBooking::with('booking', 'operator')->where('booking_id', $id)->first();
    $security_deposit = 0.3 * $quote->amount;
    $amount_remaining = 0.7 * $quote->amount;
    return response()->json([
        'quote'  => $quote, 
        'security_deposit' => $security_deposit,
        'amount_remaining' => $amount_remaining
        ]);
    }

    public function completed($id)
    {
        $quote = QuoteBooking::with('booking', 'operator')->where('booking_id', $id)->first();
        
        return response()->json([
            'quote'  => $quote
            ]);
    }

    public function cancelled($id)
    {
        $quote = QuoteBooking::with('booking', 'operator')->where('booking_id', $id)->first();
       
        return response()->json([
            'quote'  => $quote
            ]);
    }

    public function statistics()
    {
        set_time_limit(0);

        $data[] = "";
        $data_op[] = "";
        $row = "";
        $operators = Operator::whereStatus(1)->get();
        $users = User::get();
        $i=0;$j=0;
        foreach($users as $key => $user){
            $row = $this->user($user->id);
            if($row[0]->requested == 0 && $row[0]->accepted == 0 && $row[0]->completed ==0 && $row[0]->cancelled ==0 && $row[0]->cancelled == 0){
                continue;
            }
            $data[$i] = [
                'id' => $user->id,
                'date' => $user->created_at,
                'name' => $user->name,
                'requested' => $row[0]->requested ?? 0,
                'accepted' => $row[0]->accepted ?? 0,
                'completed' => $row[0]->completed ?? 0,
                'cancelled' => $row[0]->cancelled ?? 0,
                'paid' => $row[0]->paid ?? 0,
            ];
            $i++;
        }

        foreach($operators as $key => $op){
            $row = $this->operator($op->id);
             if($row[0]->sent == 0 && $row[0]->ignored == 0 && $row[0]->accepted ==0 && $row[0]->rejected ==0 && $row[0]->completed == 0 &&  $row[0]->cancelled == 0){
                continue;
            }
            $data_op[$j] = [
                'id' => $op->id,
                'date' => $op->created_at,
                'name' => $op->name,
                'sent' => $row[0]->sent ?? 0,
                'ignored' => $row[0]->ignored ?? 0,
                'accepted' => $row[0]->accepted ?? 0,
                'rejected' => $row[0]->rejected ?? 0,
                'completed' => $row[0]->completed ?? 0,
                'cancelled' => $row[0]->cancelled ?? 0,
                'quotations' => $row[0]->quotations ?? 0,
            ];
            $j++;
        }
            
       
        return response()->json([
            'users'  => $data,
            'operators'  => $data_op
            ]);
    }

    public function userStats($id){
        $data = "";
        $user = User::find($id);
        $row = $this->user($user->id);
        $data = [
            'id' => $user->id,
            'date' => $user->created_at,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone_no,
            'requested' => $row[0]->requested ?? 0,
            'accepted' => $row[0]->accepted ?? 0,
            'completed' => $row[0]->completed ?? 0,
            'cancelled' => $row[0]->cancelled ?? 0,
            'paid' => $row[0]->paid ?? 0,
        ];

        return response()->json([ 'user'  => $data ]);
    }

    public function operatorStats($id){
        $data = "";
        $operator = Operator::find($id)->whereStatus(1)->first();
        $row = $this->operator($id);
        
        $data = [
            'id' => $operator->id,
            'date' => $operator->created_at,
            'name' => $operator->name,
            'email' => $operator->email,
            'phone' => $operator->phone_no,
            'sent' => $row[0]->sent ?? 0,
            'ignored' => $row[0]->ignored ?? 0,
            'accepted' => $row[0]->accepted ?? 0,
            'rejected' => $row[0]->rejected ?? 0,
            'completed' => $row[0]->completed ?? 0,
            'cancelled' => $row[0]->cancelled ?? 0,
            'quotations' => $row[0]->quotations ?? 0,
            'total' => $row[0]->total ?? 0,
        ];

        return response()->json([ 'operator'  => $data ]);
    }

    public function user($id){
        // $record = DB::select("SELECT (SELECT count(b.id) FROM bookings b INNER JOIN users u on u.id=b.user_id WHERE b.user_id=".$id.") as requested, (SELECT count(b.id) FROM bookings b INNER JOIN users u on u.id=b.user_id INNER JOIN quote_bookings qb on qb.booking_id=b.id WHERE b.user_id=".$id." and qb.status = 1) as accepted, (SELECT count(b.id) FROM bookings b INNER JOIN users u on u.id=b.user_id INNER JOIN quote_bookings qb on qb.booking_id=b.id WHERE b.user_id=".$id." and b.status = 4) as completed, (SELECT count(b.id) FROM bookings b INNER JOIN users u on u.id=b.user_id INNER JOIN quote_bookings qb on qb.booking_id=b.id WHERE b.user_id=".$id." and b.status = 5) as cancelled, (SELECT sum(qb.amount) FROM bookings b INNER JOIN users u on u.id=b.user_id INNER JOIN quote_bookings qb on qb.booking_id=b.id WHERE b.user_id=".$id." and b.status=4) as paid FROM `bookings` limit 1");
        $record = DB::select("SELECT (SELECT count(b.id) FROM bookings b INNER JOIN users u on u.id=b.user_id WHERE b.user_id=".$id.") as requested, (SELECT count(b.id) FROM bookings b INNER JOIN users u on u.id=b.user_id WHERE b.user_id=".$id." and b.status = 1) as accepted, (SELECT count(b.id) FROM bookings b INNER JOIN users u on u.id=b.user_id  WHERE b.user_id=".$id." and b.status = 4) as completed, (SELECT count(b.id) FROM bookings b INNER JOIN users u on u.id=b.user_id WHERE b.user_id=".$id." and b.status = 5) as cancelled, (SELECT sum(qb.amount) FROM bookings b INNER JOIN users u on u.id=b.user_id INNER JOIN quote_bookings qb on qb.booking_id=b.id WHERE b.user_id=".$id." and b.status=4) as paid FROM `bookings` limit 1");

        return $record;
    }

    public function operator($id){
        $record = DB::select("SELECT (SELECT count(b.id) FROM bookings b INNER JOIN quote_bookings qb on qb.booking_id=b.id INNER JOIN operators op on op.id=qb.operator_id WHERE qb.operator_id=".$id.") as sent, (SELECT count(b.id) FROM bookings b INNER JOIN quote_bookings qb on qb.booking_id=b.id INNER JOIN operators op on op.id=qb.operator_id WHERE qb.operator_id=".$id." and qb.status = 0) as ignored,
        (SELECT count(b.id) FROM bookings b INNER JOIN quote_bookings qb on qb.booking_id=b.id INNER JOIN operators op on op.id=qb.operator_id WHERE qb.operator_id=".$id." and qb.status = 1) as accepted,
        (SELECT count(b.id) FROM bookings b INNER JOIN quote_bookings qb on qb.booking_id=b.id INNER JOIN operators op on op.id=qb.operator_id WHERE qb.operator_id=".$id." and qb.status = 2) as rejected,
        (SELECT count(b.id) FROM bookings b INNER JOIN quote_bookings qb on qb.booking_id=b.id INNER JOIN operators op on op.id=qb.operator_id WHERE qb.operator_id=".$id." and b.status = 6) as cancelled,
        (SELECT count(b.id) FROM bookings b INNER JOIN quote_bookings qb on qb.booking_id=b.id INNER JOIN operators op on op.id=qb.operator_id WHERE qb.operator_id=".$id." and b.status = 4) as completed,
        (SELECT quotations from operators where id=".$id.") as quotations, (SELECT SUM(amount) from operator_payment_logs where id=".$id.") as total FROM `bookings` limit 1");

        return $record;
    }

    public function refund(Request $request)
    {
       
        $booking = Booking::find($request->booking_id);
       if($booking && $booking->is_refund==0){
        
        Booking::where('id', $request->booking_id)->update(['is_refund' => 1]);
        return response()->json([
            'status' => true,
            'message'  => 'Refund marked paid '
        ], 200);
       }else{
        Booking::where('id', $request->booking_id)->update(['is_refund' => 0]);
        return response()->json([
            'status' => true,
            'message'  => 'Refund marked un-paid '
        ], 200);
       }

       
    //    else{
    //     return response()->json([
    //         'status' => false,
    //         'message'  => 'Something went wrong'
    //     ], 422);
    //    }
        
    }

    public function payOperator(Request $request)
    {
        $booking = Booking::find($request->booking_id);
       if($booking && $booking->is_paid==0){
        Booking::where('id', $request->booking_id)->update(['is_paid' => 1]);
        return response()->json([
            'status' => true,
            'message'  => 'Amount marked paid'
        ], 200);
       }else if($booking && $booking->is_paid==1){
        Booking::where('id', $request->booking_id)->update(['is_paid' => 0]);
        return response()->json([
            'status' => true,
            'message'  => 'Already marked un-paid'
        ], 200);
       }
       
       else{
        return response()->json([
            'status' => false,
            'message'  => 'Something went wrong'
        ], 422);
       }
        
    }

    public function sendQuotes(Request $request)
    {
       //dd($request->all());
       $operator = Operator::find($request->operator_id);
       if($operator){
        $operator->quotations = $operator->quotations + $request->quotes;
        $operator->save();

        $operator->notify(new WalletNotification(0, 'admin', $request->quotes));

        return response()->json([
            'status' => true,
            'message'  => 'Quotations added successfully '
        ], 200);
       }else{
        return response()->json([
            'status' => false,
            'message'  => 'Something went wrong'
        ], 422);
       }
    }


}
