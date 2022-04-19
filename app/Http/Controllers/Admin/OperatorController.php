<?php

namespace App\Http\Controllers\Admin;

use App\Core\Filters\OperatorFilters;
use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\Operator\Minibus;
use App\Operator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Notifications\UserRegistration;
use App\Notifications\OperatorNotification;
use App\OperatorRating;
use App\Chat\Soachat;
use DB;



class OperatorController extends Controller
{
    public function index(Request $request){
        $total = $operators = Operator::count();
       if($request->query('blocked')){
            $total = $operators = Operator::where('status', '=', config('app.status.blocked'))->count();
            $operators = Operator::where('status', '=', config('app.status.blocked'))->orderBy('id', 'desc')->paginate(10);
        }
        else{
            $total = $operators = Operator::where('status', '!=', config('app.status.blocked'))->count();
            $operators = Operator::where('status', '!=', config('app.status.blocked'))->orderBy('id', 'desc')->paginate(10);
        }

        return response()->json(['operators'=>$operators, 'total'=>$total]);
    }

    public function edit(Request $request, $id){
        $operator = Operator::find($id);
        $minibus = $operator->minibus;
        $reviews = OperatorRating::with('user')->where('operator_id', $id)->orderBy('id', 'DESC')->get();
        return ['operator' => $operator, 'minibus' => $minibus, 'reviews'=>$reviews ];
    }

    public function store(Request $request){
        $request->validate([
            "name" => "required",
            "company_name" => "required",
            "email" => "required|unique:users",
            "phone_no" => "required",
            "address" => "required",
            "country" => "required",
            "city" => "required",
            "zipcode" => "required",
            "state" => "required",
            'password' => ['required', 'string', 'min:8', 'same:confirm'],
            "model" => "required",
            "capacity" => "required|numeric",
            "type" => "required",
            "image" => "required",
            "files.*" => "required",
        ],[
            'zipcode.required' => 'Postal code is required',
            'state.required' => 'County is required',
            'image.required' => 'Profile picture is required',
            'files.*.required' => 'Minibus pictures are required',
        ]);

        DB::beginTransaction();
        try{
            $operator = new Operator();
            $data = $request->only($operator->getFillable());
            $data['password'] = bcrypt($data['password']);
            $data['status'] = 1;
            $operator->fill($data);
            $operator->save();
            
            Soachat::addUser($operator->id, $operator->name, NULL, 1);

            if($request->file('image')){
                $path = 'operator/'.md5($operator->id).'/minibus/';
                $image = Operator::upload($request->file('image'), $path, 'public', null);
                if(isset($image)){
                $operator->image = $image;
                $operator->save();
            }

            }
            $operator->addMinibuses($request, $operator);
            $operator->notify(new UserRegistration('user'));
            DB::commit();
        }catch( \Exception $e){
            DB::rollback();
            return response()->json([
                'message' => 'Operator can not be saved',
                'error' => $e
            ], 500);
        }

        return response()->json([
            'message' => 'Operator has been added successfully',
        ]);
    }

    public function update(Request $request){
  //dd($request->file('image'));
        $request->validate([
            'name' => 'required',
            'phone_no' => 'required',
            'address' => 'required',
            'country' => 'required',
            'city' => 'required',
            'zipcode' => 'required',
            'state' => 'required',
        ],[
            'zipcode.required' => 'Postal code is required',
            'state.required' => 'County is required'
        ]);
        
        if($request->password != '' || $request->password != null){
            $request->validate([
                'password' =>  ['required', 'string', 'min:8'],
            ]);
        }
        DB::beginTransaction();
        try{
            $operator = Operator::findOrFail($request->id);
            if($request->file('image')){
                $path = 'operator/'.md5($operator->id).'/minibus/';
                $image = Operator::upload($request->file('image'), $path, 'public', null);
            }
            $fields = $request->only($operator->getFillable());
           
            unset($fields['password']);
            unset($fields['email']);
            if($request->password != '' || $request->password != null)
                $fields['password'] = Hash::make($request->password);

            $operator->update($fields);

            if(isset($image)){
                $operator->image = $image;
                $operator->save();
            }

            if($request->thumbs && count($request->thumbs)){
                foreach($request->thumbs as $key){
                    Media::where('id', $key)->delete();
                }
            }

            $operator->updateMinibus($request, $operator, $operator->minibus[0]->id);

           DB::commit();
        }catch( \Exception $e){
            DB::rollback();

            return response()->json([
                'message' => 'Operator can not be updated',
                'error' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'message' => 'Operator has been updated successfully',
        ]);
    }

    public function changeStatus(Request $request, $id){
       // dd($request->all());
        $operator = Operator::find($id);
        if($operator->status == config('app.status.blocked')){
            $operator->status = config('app.status.approved');
            $operator->save();

            return response()->json([
                'message' => 'Operator is now unblocked',
            ]);

        }else if($request->status == 1){
            $operator->status = config('app.status.approved');
            $operator->save();
            try{
                $operator->notify(new OperatorNotification('Congratulations! Your account has been approved.', 'approve'));
            }catch(\Throwable $ex){

            }
            
            return response()->json([
                'message' => 'Operator is approved',
            ]);
        }
        else if($request->status == 3){
            $operator->status = 3;
            $operator->save();
            try{
            $operator->notify(new OperatorNotification('Your profile has been rejected.', 'reject'));
             }catch(\Throwable $ex){

            }
            return response()->json([
                'message' => 'Operator is rejected',
            ]);
        }
        else{
            $operator->status = config('app.status.blocked');
            $operator->save();

            return response()->json([
                'message' => 'Operator is blocked successfully',
            ]);

        }
    }

   

    
}
