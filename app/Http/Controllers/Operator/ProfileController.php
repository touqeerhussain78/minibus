<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Operator;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:operators')->except('logout');
    }

    public function index(){
        $id = auth('operators')->user()->id;
        $operator = Operator::with('minibus')->find($id);
        $buses = $operator->minibus[0]->media;
        return view('operators.profile.index', compact('operator', 'buses'));
    }

    public function edit(){
        $id = auth('operators')->user()->id;
        $operator = Operator::with('minibus')->find($id);
        $buses = $operator->minibus[0]->media;
        
        return view('operators.profile.edit', compact('operator', 'buses'));
    }
}
