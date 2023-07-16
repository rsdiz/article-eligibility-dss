<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alternative extends Model
{
    use HasFactory;

    protected $table = 'alternatives';
    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $guarded = ['id'];

    protected $fillable = [
        'post_id'
    ];

    public function hasScores()
    {
        return (bool) $this->scores()->first();
    }

    public function scores()
    {
        return $this->hasMany(Score::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
