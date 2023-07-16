<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    protected $guarded = ['id'];
    public $timestamps = true;

    public function category(): BelongsTo
    {
        return $this->belongsTo('App\Models\Category');
    }
}
