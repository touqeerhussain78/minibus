<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Core\Traits\ImageableFill;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes, ImageableFill;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role_id', 'name', 'surname', 'email', 'password', 'address', 'country', 'state', 'zipcode', 'status', 'city', 'phone_no', 'auth_code_phone', 'auth_code_email','is_verified', 'image', 'uuid'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

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

    public function getImageAttribute($value){
        return $value ? asset("storage/{$value}") : null;

    }

    public function getCreatedAtAttribute($value)
    {
        return date("d-m-Y", strtotime($value));
    }

    public static function upload($uploadedFile, $folder = null, $disk = 'public', $filename = null)
    {
        $name = !is_null($filename) ? $filename : Str::random(25);
        (!\File::isDirectory(storage_path('app/public/'.$folder))) ?  \File::makeDirectory(storage_path('app/public/'.$folder), 0777, true, true) : '';
        $file = $uploadedFile->storeAs($folder, $name.'.'.$uploadedFile->getClientOriginalExtension(), $disk);
        return $file;
    }

   // protected $imageFolder = 'profile';

}
