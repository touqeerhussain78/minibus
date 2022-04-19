<?php

namespace App;

use App\Models\Operator\Minibus;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Traits\ImageableFill;
use Illuminate\Support\Str;

class Operator extends Authenticatable
{
    use Notifiable, SoftDeletes, ImageableFill;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','username', 'company_name', 'email', 'password', 'address', 'country', 'state', 'zipcode', 'status', 'city', 'phone_no', 'image', 'aboutme', 'drivers_license', 'quotations', 'latitude', 'longitude', 'uuid'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $with = ['minibus'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }

    protected $imageFolder = 'operator/profile';

    public function minibus(){
        return $this->hasMany(Minibus::class, 'operator_id');
    }

    public static function upload($uploadedFile, $folder = null, $disk = 'public', $filename = null)
    {
        $name = !is_null($filename) ? $filename : Str::random(25);
        (!\File::isDirectory(storage_path('app/public/'.$folder))) ?  \File::makeDirectory(storage_path('app/public/'.$folder), 0777, true, true) : '';
        $file = $uploadedFile->storeAs($folder, $name.'.'.$uploadedFile->getClientOriginalExtension(), $disk);
        return $file;
    }

    public function addMinibuses($request, $operator){
        $minibus = $operator->minibus()->save(new Minibus([
            'model' => $request->model,
            'capacity' => $request->capacity,
            'type' => $request->type,
            'description' => $request->description,
        ]));


        if($request->file('files')){
            foreach ($request->file('files') as $key => $file){
                $path = 'operator/'.md5($operator->id).'/minibus/';
                $image = self::upload($file, $path, 'public', null);
                $minibus->media()->save(new \App\Models\Media([
                    'path'   => $image,
                    'status' => 0,
                    //'nature' => 'minibus'
                ]));
            }
        }
    }
    
    public function updateMinibus($request, $operator, $minibus_id){
     
        $minibus = Minibus::find($minibus_id);
        $minibus->model = $request->model;
        $minibus->capacity = $request->capacity;
        $minibus->type = $request->type;
        $minibus->description = $request->description;
       
        $minibus->save();
        if($request->file('files')){
            foreach ($request->file('files') as $key => $file){
                $path = 'operator/'.md5($operator->id).'/minibus/';
                $image = self::upload($file, $path, 'public', null);
                $minibus->media()->save(new \App\Models\Media([
                    'path'   => $image,
                    'status' => 0,
                    //'nature' => 'minibus'
                ]));
            }
        }
    }

public function routeNotificationForMail($notification)
{
    return $this->email;
}

public function getCreatedAtAttribute($value)
{
    return date("d-m-Y", strtotime($value));
}



}
