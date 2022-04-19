<?php

namespace App\Http\Controllers\Admin;

use App\Core\Filters\UserFilters;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Notifications\UserRegistration;
use App\Chat\Soachat;

class UserController extends Controller
{
    public function index(Request $request){
        if($request->query('blocked'))
            $users = User::where('status', '=', config('app.status.blocked'))->orderBy('id', 'desc')->get();
        else
            $users = User::where('status', '!=', config('app.status.blocked'))->orderBy('id', 'desc')->get();
        return $users;
    }

    public function edit(Request $request, $id){
        $user = User::find($id);
        return $user;
    }

    public function store(Request $request){
     //   dd($request->all());
        $request->validate([
            'surname' => 'required|unique:users',
            'name' => 'required',
            'email' => 'required|unique:users',
            'phone_no' => 'required|min:7',
            'address' => 'required',
            'country' => 'required',
            'city' => 'required',
            'zipcode' => 'required',
            'state' => 'required',
            'password' =>  ['required', 'string', 'min:8', 'same:confirm'],
        ]);


        $user = new User();
        $data = $request->only($user->getFillable());
        $data['password'] = bcrypt($data['password']);
        $data['status'] = 1;

        $user->fill($data);
        $user->save();
        Soachat::addUser($user->id, $user->name, NULL, 1);
        
         if($request->file('image')){
                $path = 'users/'.md5($user->id).'/minibus/';
                $image = User::upload($request->file('image'), $path, 'public', null);
                if(isset($image)){
                $user->image = $image;
                $user->save();
            }
        }

        $user->notify(new UserRegistration('user'));

        return response()->json([
            'message' => 'User has been added successfully',
        ]);
    }

    public function update(Request $request){
      //  dd($request->all());
        $request->validate([
            'surname' => 'required|unique:users,username,'.$request->id,
            'name' => 'required',
            'phone_no' => 'required|min:8',
            'address' => 'required',
            'country' => 'required',
            'city' => 'required',
            'zipcode' => 'required',
            'state' => 'required',
        ]);

        if($request->password != '' || $request->password != null){
            $request->validate([
                'password' =>  ['required', 'string', 'min:8'],
            ]);
        }


        $user = User::findOrFail($request->id);
        // if($request->file('image')){
        //     $path = 'users/'.md5($user->id).'/minibus/';
        //     $image = User::upload($request->file('image'), $path, 'public', null);
        // }
        $fields = $request->only($user->getFillable());
        unset($fields['password']);
        if($request->password != '' || $request->password != null)
            $fields['password'] = Hash::make($request->password);

        $user->update($fields);
       
        if($request->file('image')){
                         $path = 'users/'.md5($user->id).'/minibus/';
                         $image = User::upload($request->file('image'), $path, 'public', null);
                         if(isset($image)){
                         $user->image = $image;
                        $user->save();
                       }
                 }
        return response()->json([
            'message' => 'User has been updated successfully',
        ]);
    }

    public function changeStatus(Request $request, $id){
        $user = User::find($id);
        if($user->status == config('app.status.blocked')){
            $user->status = config('app.status.approved');
            $user->save();

            return response()->json([
                'message' => 'User is now unblocked',
            ]);

        }else{
            $user->status = config('app.status.blocked');
            $user->save();

            return response()->json([
                'message' => 'User is blocked successfully',
            ]);

        }
    }
}
