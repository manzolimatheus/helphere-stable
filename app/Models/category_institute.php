<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class category_institute extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function institutes(){
        return $this->hasMany('App\Models\Institute'); //Uma categoria pode ter muitas instituições
    }


}
