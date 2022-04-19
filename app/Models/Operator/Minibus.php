<?php

namespace App\Models\Operator;

use App\Models\Media;
use Illuminate\Database\Eloquent\Model;

class Minibus extends Model
{
    protected $fillable = ['operator_id', 'model', 'type', 'description', 'capacity'];

    protected $table = 'operators_minibuses';

    protected $with = ['media'];

    public function media(){
        return $this->morphMany(Media::class, 'mediaable');
    }


}
