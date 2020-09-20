<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class Book extends Model
{
    protected $guarded = [];
    protected $fillable = [];
    public function category()
    {
        return $this->belongsTo('App\Category');
    }
}
