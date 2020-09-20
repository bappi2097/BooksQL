<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];
    protected $fillable = [];
    public function books()
    {
        return $this->hasMany('App\Book');
    }
}
