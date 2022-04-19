<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TempMedia extends Model
{
    protected $table = "temp_media";

    protected $fillable = ['identifier', 'path'];
}
