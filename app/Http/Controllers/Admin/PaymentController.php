<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\{
    Booking,
    QuoteBooking,
    QuotationPackage,
    OperatorPaymentLog,
    PaymentLog
};
use DB;

class PaymentController extends Controller
{
    public function index(Request $request){
        $users = Booking::select(['bookings.*', 'users.*', 'quote_bookings.*', 'bookings.status as booking_status'])
                        ->join('users', 'users.id','=','bookings.user_id')
                          ->join('quote_bookings', 'bookings.id','=','quote_bookings.booking_id')
                          ->whereIn('bookings.status',[4, 5]);

        if ($request->filled('from') && $request->filled('to')) {
        $users->where(function ($query) use ($request) {
            $query->whereBetween('bookings.created_at', [$request->from, $request->to]);
        }); 
        }

        $users = $users->orderBy('bookings.id', 'DESC')->get()->toArray();

        $operators = Booking::select(['bookings.*', 'operators.*', 'quote_bookings.*', 'bookings.status as booking_status'])
                            ->join('quote_bookings', 'bookings.id','=','quote_bookings.booking_id')
                    ->join('operators', 'operators.id','=','quote_bookings.operator_id')
                    ->whereIn('bookings.status',[4, 5]);

        if ($request->filled('start') && $request->filled('end')) {
            $operators->where(function ($query) use ($request) {
                $query->whereBetween('bookings.created_at', [$request->start, $request->end]);
            }); 
            }

        $operators = $operators->orderBy('bookings.id', 'DESC')->get()->toArray();

        return response()->json([
            'users'  => $users, 
            'operators' => $operators
            ]);
    }


    public function packages(){
        $packages = QuotationPackage::get();
        return response()->json(['packages' => $packages]);
    }

    public function operatorPaymentLogs(){
        $data[] = "";
        $payments = OperatorPaymentLog::with('package', 'operator')->orderBy('id', 'desc')->get();
        
        foreach($payments as $key => $value){
            $data[$key] = [
                'id' => $value->id,
                'date' => $value->created_at,
                'operator_name' => $value->operator->name,
                'package' => 'Package '.$value->package->id,
                'amount' => $value->amount,
            ];
        }
       
        return response()->json(['payments' => $data]);
    }

    public function myPayments(){
        $data[] = "";
        $operator = OperatorPaymentLog::with('operator')->get()->toArray();
        $users = PaymentLog::with('user', 'booking')->get()->toArray();
        $total = array_merge($operator, $users);
        $operator_total = \DB::table('operator_payment_logs')->sum('amount');
        $user_total = \DB::table('payment_logs')->sum('amount');
        $nettotal = $operator_total+$user_total;
       
        foreach($total as $key => $value){
            $data[$key] = [
                'id' => $key,
                'date' => $value['created_at'],
                'type' => isset($value['operator']['name']) ? 'Operator' : 'User',
                'name' => $value['operator']['name'] ?? $value['user']['name'],
                'action' => isset($value['operator']['name']) ? 'Quotation Bought' : 'Booking Confirmation',
                'amount' => $value['amount'],
                'paid' => (isset($value['booking']['is_refund']) && $value['booking']['is_refund'] == 1) ? $value['amount'] : 0,
            ];
        }
     
        return response()->json(['payments' => $data, 'total'=>$nettotal]);
    }

    public function myPaymentsChartData(){
        $records = Booking::join('quote_bookings as qb', 'qb.booking_id', '=', 'bookings.id')
                           // ->where('bookings.status', 4)
                            ->select(DB::raw("SUM(qb.amount) as count, MONTH(qb.created_at) month"))
                            ->groupBy(DB::raw("year(qb.created_at), MONTH(qb.created_at)"))
                            ->get();

        $month = Booking::join('quote_bookings as qb', 'qb.booking_id', '=', 'bookings.id')
                            //->where('bookings.status', 4)
                            ->select(DB::raw("SUM(qb.amount) as count"))
                            ->orderBy("bookings.created_at")
                            ->groupBy(DB::raw("month(bookings.created_at)"))
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
     
        return response()->json(['data' => $chartData]);
    }
}
