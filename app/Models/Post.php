<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = ['id'];
    public $timestamps = true;

    public function categories()
    {
        return $this->belongsToMany('App\Models\Category');
    }
}
