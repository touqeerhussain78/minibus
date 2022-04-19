<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Operator;
use App\Models\Operator\Minibus;
use App\OperatorRating;
use App\Mail\NewsletterMail;
use App\Subscriber;
use App\Feedback;
use Session, Redirect;
use Illuminate\Support\Facades\Http;
use Str;
use App\User;
use App\Chat\Soachat;
use Mail;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $operators = Operator::with('minibus')->orderBy('id','desc')->limit(6)->get();
        return view('home', compact('operators'));
    }

    public function getOperator($id)
    {
        if(\Auth::check()){
           $check = OperatorRating::where('user_id', auth()->user()->id )->where('operator_id', $id)->first();
           $allowed = isset($check) ? 0 : 1;
        }
        $operator = Operator::with('minibus')->find($id);
        $buses = $operator->minibus[0]->media ?? "";
        $reviews = OperatorRating::with('user')->where('operator_id', $id)->orderBy('id', 'DESC')->get();
        return view('operator', compact('operator', 'buses', 'reviews'));
    }

    public function submitNewsletter(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'unique:subscribers'],
        ]);

        $subscribe = Subscriber::create($request->toArray());
        
       // Mail::to('info@minibus.com')->send(new NewsletterMail($request->all()));

        return response()->json(['message' => 'Thanks for subscribing to our newsletter']);
    }

    public function messages()
    {
        //update message counter to 0
        $user = \Auth::user();
        $update = User::where('id',$user->id)->update(['notification_count' => 0]);
        
        return view('user.messages');
    }

    public function about()
    {
        $title = 'About Us';
        return view('user.about', compact('title'));
    }

    public function services()
    {
        $title = 'Services';
        return view('user.about', compact('title'));
    }

    public function clients()
    {
        $title = 'Clients';
        return view('user.about', compact('title'));
    }

    public function advertise()
    {
        $title = 'Advertise';
        return view('user.about', compact('title'));
    }

    public function allOperators()
    {
        $title = 'All Operators';
        $operators = Operator::with('minibus')->orderBy('id','desc')->get();
        return view('all-operators', compact('operators'));
    }

    public function search(Request $request)
    {
        $title = 'Minibus Search Results';
        
        if ($request->filled('search')) {
            $operators = Operator::where('name', 'like', "%{$request->search}%" );
        
            
        }
        $operators = $operators->orderBy('id', 'desc')->get();
       // dd($operators);
    //     $minibus = Minibus::orderBy('id', 'desc');
    //     if ($request->filled('search')) {
    //         $minibus->where(function ($query) use ($request) {
    //                 $query->where('model', 'like', '%'.$request->search.'%' );
    //         });
           
    //     }

    //    $minibuses = $minibus->get();
    //     foreach($minibuses as $key => $value){
    //         $operators = Operator::where('id', $value->operator_id)->get();
    //     }
        
      
        return view('search', compact('title', 'operators'));
    }

    public function contact()
    {
        return view('user.contact-us');
    }

    public function contactStore(Request $request)
    {
        $request->validate([
            'subject' => 'required',
            'email' => 'required',
            'message' => 'required',
            'g-recaptcha-response' => 'required'
        ],[
            'g-recaptcha-response.required'=> 'Captcha field is required'
        ]);
        //try{
        $secret = env('RECAPTCHA_SECRET_KEY');

        // $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
        //     'secret' => $secret,
        //     'response' => $request['g-recaptcha-response'],
        // ]);
        // if($response.success==true){
            $feedback = new Feedback;
            $feedback->type = auth()->user() ? 1 : 3; // 3 for non-loged in users
            if(\Auth::guard('web')->check() || \Auth::guard('operators')->check()){
                $feedback->user_id = auth()->user()->id ;
            }
            
            $feedback->email = $request->email;
            $feedback->subject = $request->subject;
            $feedback->message = $request->message;
            $feedback->save();
    
            Session::flash('message', 'Your message has been sent successfully.');
    
        // }else{
        //     Session::flash('error', 'Unable to send! Please check the given data.');
        // }
       
        // }catch( \Exception $e){
        //     Session::flash('error', 'Unable to send! Please check the given data.');
        // }
        return redirect('/contact-us');

    }
    
       public function updateUuid(){
           die;
        //adding all users & operators to soachat
        
         $i=0;
        // $allUsers = User::where('uuid', '!=', NULL)->get();
        $allOperators = Operator::where('uuid', '!=',NULL)->offset(1600)->limit(100)->get();
        // return $allOperators;
        if(count($allOperators)){
            foreach($allOperators as $operator){
                // dd($user);
                if($operator->name){
                    Soachat::addUser($operator->uuid, $operator->name, NULL, 1);
                }
                elseif($operator->company_name){
                    Soachat::addUser($operator->uuid, $operator->company_name, NULL, 1);
                }
                $i++;
            }
        }

        echo $i;
        die;
        
        
        
           
        //added uuid to all users and operators   
        $allUsers = User::where('uuid', NULL)->get();
        $allOperators = Operator::where('uuid', NULL)->get();
        $i=0;
        if(count($allUsers)){
            foreach($allUsers as $user){
                $uuid = Str::uuid();
                $update = User::where('id', $user->id)->update(['uuid'=> $uuid]);
                $i++;
            }
        }
        if(count($allOperators)){
            foreach($allOperators as $operator){
                $uuid = Str::uuid();
                $update = Operator::where('id', $operator->id)->update(['uuid'=> $uuid]);
                $i++;
            }
        }
echo $i;
        die();

    }


    public function mail_check(){
        // $lat = -0.0877321;
        // $long = 51.5078788;

        $longitude = (float) 33.33333;
        $latitude = (float) 22.22222;
        $radius = 30; // in miles
        $lng_min = $longitude - $radius / abs(cos(deg2rad($latitude)) * 69);
        $lng_max = $longitude + $radius / abs(cos(deg2rad($latitude)) * 69);
        $lat_min = $latitude - ($radius / 69);
        $lat_max = $latitude + ($radius / 69);

        // echo 'longitude (min/max): ' . $lng_min . ' / ' . $lng_max ; echo "<br>";
        // echo 'latitude (min/max): ' . $lat_min . ' / ' . $lat_max;
        $this->lat = 51.5078788;
        $this->lng = -0.0877321;
        $lat = 51.5078788;
        $lng = -0.0877321;


        $operators_email = 
                \DB::table("operators")
                ->select("operators.id","operators.email", \DB::raw("6371 * acos(cos(radians(" . $lat . "))
            * cos(radians(operators.latitude)) 
            * cos(radians(operators.longitude) - radians(" . $lng . ")) 
            + sin(radians(" . $lat . ")) 
            * sin(radians(operators.latitude))) AS distance"))
                ->having('distance', '<', 30)
                ->get();

        $emails = array();
        foreach( $operators_email as $item){
            $emails[] = $item->email;
        }
        // return $emails;


        try {
            Mail::raw("Trip Create', 'Trip# has been Create by user", function ($message) use ($emails) {
                $message->to($emails)
                    ->subject('USER TRIP Created - MINIBUS -  ')->from('richardsteve979@gmail.com');
            });
            // return "its work";
        } catch (\Exception $e) {
        }  
    
    }




}
