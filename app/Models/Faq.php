<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    protected $guarded = [];

    // scopre search
    public function scopeSearch(Builder $query, $val)
    {
        if ($val == '') {
            return $query;
        }
        return $query->where('question', 'like', '%' . $val . '%')
            ->orWhere('answer', 'like', '%' . $val . '%');
    }
}
