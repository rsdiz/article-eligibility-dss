<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    use HasFactory;

    protected $table = 'scores';
    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $guarded = ['id'];

    protected $fillable = [
        'criteria_id', 'alternative_id', 'value'
    ];

    public function criteria()
    {
        return $this->belongsTo(Criteria::class);
    }
}
