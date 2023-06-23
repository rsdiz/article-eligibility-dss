<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Saved extends Model
{
    protected $guarded = ['id'];
    public $timestamps = true;

    public function post()
    {
        return $this->belongsTo('App\Models\Post');
    }
}
