<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use App\Models\Settings;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use SoftDeletes;
    use TwoFactorAuthenticatable;

    protected $guarded = [];

    /**
     * Disable email verification completely
     */
    public function sendEmailVerificationNotification()
    {
        // Do nothing (verification disabled)
        return;
    }

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'profile_photo_url',
    ];

    public function dp()
    {
        return $this->hasMany(Deposit::class, 'user');
    }

    public function wd()
    {
        return $this->hasMany(Withdrawal::class, 'user');
    }

    public function tuser()
    {
        return $this->belongsTo(Admin::class, 'assign_to', 'id');
    }

    public function dplan()
    {
        return $this->belongsTo(Plans::class, 'plan');
    }

    public function plans()
    {
        return $this->hasMany(User_plans::class, 'user', 'id');
    }

    // Users this user has referred (direct referrals)
    public function referrals()
    {
        return $this->hasMany(User::class, 'ref_by', 'id');
    }

    // The user who referred this user
    public function referrer()
    {
        return $this->belongsTo(User::class, 'ref_by', 'id');
    }

    // Parent user (for secondary accounts)
    public function parentUser()
    {
        return $this->belongsTo(User::class, 'parent_user_id', 'id');
    }

    // Secondary accounts of this user (2nd account)
    public function secondaryAccounts()
    {
        return $this->hasMany(User::class, 'parent_user_id', 'id')->where('is_secondary', 1);
    }

    // Third accounts of this user (3rd account)
    public function thirdAccounts()
    {
        return $this->hasMany(User::class, 'parent_user_id', 'id')->where('is_secondary', 2);
    }

    // Fourth accounts of this user (4th account)
    public function fourthAccounts()
    {
        return $this->hasMany(User::class, 'parent_user_id', 'id')->where('is_secondary', 3);
    }

    // Second account request
    public function secondAccountRequest()
    {
        return $this->hasOne(SecondAccountRequest::class, 'user_id', 'id');
    }

    // Third account request
    public function thirdAccountRequest()
    {
        return $this->hasOne(ThirdAccountRequest::class, 'user_id', 'id');
    }

    // Fourth account request
    public function fourthAccountRequest()
    {
        return $this->hasOne(FourthAccountRequest::class, 'user_id', 'id');
    }

    public static function search($search): \Illuminate\Database\Eloquent\Builder
    {
        return empty($search) ? static::query()
            : static::query()
                ->where('id', 'like', "%$search%")
                ->orWhere('name', 'like', "%$search%")
                ->orWhere('username', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%")
                ->orWhere('accountid', 'like', "%$search%");
    }
}
