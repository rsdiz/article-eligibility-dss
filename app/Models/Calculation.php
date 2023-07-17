<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Calculation extends Model
{
    use HasFactory;

    protected $table = 'calculations';
    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $guarded = ['id'];
    public $timestamps = true;

    protected $fillable = [
        'category_id', 'title', 'headline_date'
    ];

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class);
    }

    public function results(): BelongsToMany
    {
        return $this->belongsToMany(Result::class);
    }
}
