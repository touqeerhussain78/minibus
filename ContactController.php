<?php

namespace Modules\Contact\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;
use Modules\Contact\Http\Requests\ContactRequest;
use DB;

class ContactController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('public.contact.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function store(ContactRequest $request)
    {
        Mail::raw($request->message, function (Message $message) use ($request) {
            $message->subject($request->subject)
                ->from($request->email)
                ->to(setting('store_email'));
        });

        return
            request()->wantsJson()?
                response()->json(['message' => trans('storefront::contact.your_message_has_been_sent')])
                : back()->with('success', trans('storefront::contact.your_message_has_been_sent'));
    }

    public function subscribe(Request $request) 
    {
        $request->validate([
            'email' => 'required|string|email|max:255|unique:subscribers',
        ],[
            'email.required' => "Email is required",
            'email.email' => "Email must be a valid email address.",
            'email.unique' => "Email already exist.",
        ]);

        $subscriber = DB::table('subscribers')->insert(['email' => $request->email]);
       
        if($subscriber){
            return response()->json(['message' => "Subscribed successfully"], 200);
        }else{
            return response()->json(['message' => "Email already exist"], 422);
        }
    }

    public function product_suggestion(Request $request) 
    {
        $request->validate([
            'email' => ['required', 'email'],
            'name' => ['required'],
            'message' => ['required'],
        ],[
            'email.required' => "Email is required",
            'name.required' => "Name is required",
            'message.required' => "Message is required",
        ]);

        $suggestion = DB::table('product_suggestions')->insert($request->toArray());
       
        if($suggestion){
            return response()->json(['message' => "Your suggestions are saved successfully"], 200);
        }else{
            return response()->json(['message' => "Unable to submit, Please check again."], 422);
        }
    }

}
