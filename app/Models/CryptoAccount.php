<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CryptoAccount extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',   // ← ADD THIS
        // add other fields here if needed
    ];
}
