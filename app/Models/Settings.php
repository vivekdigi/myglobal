<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'return_capital' => 'boolean',
        'should_cancel_plan' => 'boolean',
        'modules' => 'array',
        'themes' => 'array'
    ];

    // public function getModulesAttribute($value)
    // {
    //     return ucfirst($value);
    // }
}
