<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = ['mediaable_id', 'mediaable_type', 'path', 'status'];

    protected $table = 'medias';

    public function mediaable(){
        return $this->morphTo('mediaable');
    }

    public function getPathAttribute($value){
        return $value ? asset("storage/{$value}") : null;

    }

}
