<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'txn_id',
        'user',
        'amount',
        'address',
        'columns',
        'to_deduct',
        'status',
        'payment_mode',
        'paydetails',
        'accountid',
        'created_at',
        'updated_at',
    ];
    
    public function duser()
    {
        return $this->belongsTo(User::class, 'user');
    }

    public function scopeOfStatus(Builder $query, string $status): void
    {
        if ($status != 'All') {
            $query->where('status', $status);
        }
    }

    // scope search
    public function scopeOfSearch(Builder $query, string $search): void
    {
        if ($search != '') {
            $query->where(function ($query) use ($search) {
                $query->where('payment_mode', 'like', "%$search%")
                    ->orWhereHas('duser', function ($query) use ($search) {
                        $query->where('name', 'like', "%$search%");
                         $query->orWhere('email', 'like', "%$search%");
                         $query->orWhere('accountid', 'like', "%$search%");
                    });
            });
        }
    }

    // scope date
    public function scopeOfDate(Builder $query, string $fromDate, string $toDate): void
    {
        if ($fromDate != '' && $toDate != '') {
            //add one day to toDate
            $toDate = date('Y-m-d', strtotime($toDate . ' +1 day'));

            $query->whereBetween('created_at', [$fromDate, $toDate]);
        }
    }
}
