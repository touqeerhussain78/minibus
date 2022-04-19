<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\{
    OperatorPaymentLog,
    QuotationPackage,
    Operator,
    Admin
};
use Stripe;
use App\Notifications\WalletNotification;
use App\Notifications\AdminNotification;


class WalletController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:operators')->except('logout');
    }

    public function index()
    {
        $title = "My Wallet";
        
        $payments = OperatorPaymentLog::where('operator_id', \Auth::user()->id)->orderBy('id', 'DESC')->get();

        $packages = QuotationPackage::whereStatus(1)->get();
      
        return view('operators.wallet.index', compact('title', 'payments', 'packages'));
    }

    public function payment(Request $request)
   {
    
        $request->validate([
            'id' => ['required'],
            'name' => ['required'],
            'card_number' => 'required|min:16|max:16',
            'cvv' => 'required|min:3|max:3',
            'expiry' => ['required'],
        ],[
            'id.required'=>'Please select any package'
        ]);
        $package = QuotationPackage::find($request->id);

        Stripe\Stripe::setApiKey(config('app.stripe_secret'));
         $charge  = Stripe\Charge::create ([
                "amount" => $package->amount * 100,
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "Test payment" 
        ]);

         
         $payment = new OperatorPaymentLog;
         $payment->operator_id = auth()->user()->id;
         $payment->quotation_package_id = $request->id;
         $payment->amount = $package->amount;
         $payment->stripe_charge_id = $charge->id;
         $payment->details = json_encode($charge);
         $payment->save();
       
                $operator = Operator::find(auth()->user()->id);
                $operator->quotations += $package->quote;
                $operator->save();

               // $operator->notify(new WalletNotification($package, 'operator', ''));

               $operator->notify(new WalletNotification($package, 'operator',$package->quote));

                \Notification::send(Admin::all(), new AdminNotification('Wallet', 'A new quotation has been purchased by operator', 'quotations'));
        if($payment){
            return response()->json([ 'status'=>true, 'message' => 'Quotations added in you wallet'], 200);
        }else{
            return response()->json([ 'status'=>false, 'message' => 'something went wrong'], 200);
        }
            
        
   }

}
