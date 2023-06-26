<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    use HasFactory;

    protected $table = 'criterias';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $appends = ['option_desc'];

    protected $guarded = ['id'];

    protected $fillable = [
        'code', 'name', 'type', 'weight', 'has_option'
    ];

    public function optionDesc(): Attribute
    {
        $has_option = $this->has_option;

        return new Attribute(
            function () use ($has_option) {
                if ($has_option) {
                    return "Pilihan Sub Kriteria";
                } else {
                    return "Input Langsung";
                }
            }
        );
    }
}
