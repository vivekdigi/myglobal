<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_plans extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'activated_at' => 'datetime',
        'last_growth' => 'datetime',
        'expire_date' => 'datetime',
    ];

    public function dplan()
    {
        return $this->belongsTo(Plans::class, 'plan', 'id');
    }

    public function duser()
    {
        return $this->belongsTo(User::class, 'user', 'id');
    }

    public function scopeSort(Builder $query, $value)
    {
        if ($value == 'All' || $value == null) {
            return $query;
        } elseif ($value == 'Active') {
            return $query->where('active', 'yes');
        } elseif ($value == 'Expired') {
            return $query->where('active', 'expired');
        } else {
            return $query->where('active', 'cancelled');
        }
    }
}
