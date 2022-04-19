<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\{
    SpecialInvite
};
use Carbon\Carbon;

class SpecialInvitesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:operators')->except('logout');
    }
    
    public function index()
    {
// return
//          ('Y-m-d');
        $current_date = Carbon::now();
        
        $data = SpecialInvite::whereHas('booking',function($q) use($current_date){
                $q->whereDate('pickup_date', '>=', $current_date );
        })->join('bookings', 'bookings.id', '=', 'special_invites.booking_id')
        ->where('special_invites.operator_id', auth()->user()->id)
        ->where('bookings.status', 0)->get();;
        
        return view('operators.special-invites.index', compact('data'));
    }

    
}
