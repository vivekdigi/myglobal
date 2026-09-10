<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Deposit extends Model
{
    protected $fillable = [
    'user',
    'amount',
    'payment_mode',
    'status',
    'user_id',        // if exists
    'proof',          // if needed
    'accountid',      // if needed
    ];
    use HasFactory;

    public function duser(): BelongsTo
    {
        return $this->belongsTo('App\Models\User', 'user');
    }

    public function dplan()
    {
        return $this->belongsTo('App\Models\Plans', 'plan');
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
                $query->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%")
                    ->orWhere('accountid', 'like', "%$search%");
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
