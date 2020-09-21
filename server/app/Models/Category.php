<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];

    public function books()
    {
        return $this->hasMany('App\Book');
    }
}
