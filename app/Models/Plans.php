<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plans extends Model
{
    use HasFactory;

    protected $guarded = [];
    // has many users with this plan in user_plans table
    public function userPlans(): HasMany
    {
        return $this->hasMany(User_plans::class, 'plan', 'id');
    }
}
