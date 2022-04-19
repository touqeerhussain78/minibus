<?php

namespace App\Http\Controllers\Admin;

use App\Core\Filters\UserFilters;
use App\Http\Controllers\Controller;
use App\Operator;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DB;

class AdminController extends Controller
{
    public function dashboardStats(Request $request){
        $users = User::where('status', '!=', config('app.status.blocked'))->count();
        $operators = Operator::where('status', '!=', config('app.status.blocked'))->count();
        $bookings = \App\Booking::where('status', '=', 4)->count();
        $feedbacks = \App\Feedback::count();
        $payments = \App\OperatorPaymentLog::count();
        return response()->json([
            'users' => $users,
            'operators' => $operators,
            'bookings' => $bookings,
            'feedbacks' => $feedbacks,
            'payments' => $payments,
        ]);
    }

    public function changePassword(Request $request){
        $user = auth()->guard('admin')->user();
        if(Hash::check($request->oldPassword, $user->password )){
            if($request->newPassword !== $request->confirmNewPassword){
                return response()->json(['error' => 'New password and Confirmation password do not match'], 422);
            }
            $user->password = Hash::make($request->newPassword);
            $user->save();
            return response()->json(['message' => 'Password updated successfully']);
        }
        return response()->json(['error' => 'Old password do not match to our records '], 422);
    }

    public function updateProfile(Request $request){

      //  dd($request->all());
        $request->validate([
            "name" => "required",
            "phone_no" => "required",
            "address" => "required",
            "country" => "required",
            "city" => "required",
            "zipcode" => "required",
            "state" => "required",
        ]);

        DB::beginTransaction();
        try{
            $user = auth()->guard('admin')->user();
            $data = $request->only($user->getFillable());
            $user->fill($data);
            $user->save();

            if($request->file('image')){
                $path = 'administrator/'.md5($user->id).'/minibus/';
                $image = self::upload($request->file('image'), $path, 'public', null);
                if(isset($image)){
                $user->image = $image;
                $user->save();
            }
        }

            DB::commit();

        }catch( \Exception $e){
            DB::rollback();
            return response()->json([
                'message' => 'Profile can not be updated',
                'error' => $e
            ], 422);
        }

        return response()->json([
            'message' => 'Profile is updated successfully',
        ]);
    }

    public static function upload($uploadedFile, $folder = null, $disk = 'public', $filename = null)
    {
        $name = !is_null($filename) ? $filename : Str::random(25);
        (!\File::isDirectory(storage_path('app/public/'.$folder))) ?  \File::makeDirectory(storage_path('app/public/'.$folder), 0777, true, true) : '';
        $file = $uploadedFile->storeAs($folder, $name.'.'.$uploadedFile->getClientOriginalExtension(), $disk);
        return $file;
    }


}
