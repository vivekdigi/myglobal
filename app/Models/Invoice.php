<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function account()
    {
        return $this->belongsTo(Mt4Details::class, 'mt4_details_id', 'id');
    }

    protected $casts = [
        'reminded_at' => 'datetime:Y-m-d',
    ];
}
