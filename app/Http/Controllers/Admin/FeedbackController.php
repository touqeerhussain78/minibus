<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Feedback;
use App\Complain;

class FeedbackController extends Controller
{
    public function index(){
        $feedbacks = Feedback::with('user')->orderBy('id', 'DESC')->get();
        return response()->json([
            'feedbacks'  => $feedbacks
            ]);
    }

    public function show($id){
        $feedback = Feedback::with('user')->find($id);
        return response()->json([
            'feedback'  => $feedback
            ]);
    }

    public function reports(){
     
        $reports = Complain::with('user', 'operator', 'category')->orderBy('id', 'DESC')->get();
        return response()->json([
            'reports'  => $reports
            ]);
    }

    public function reportView($id){
     
        $feedback = Complain::with('user', 'operator', 'category')->find($id);
        return response()->json([
            'feedback'  => $feedback
            ]);
    }

    
}
