<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemoAccountRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_name',
        'user_email',
        'status',
        'admin_notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
