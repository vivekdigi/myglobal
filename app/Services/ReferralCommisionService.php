<?php

namespace App\Services;

use App\Models\Settings;
use App\Models\Tp_Transaction;
use App\Models\User;
use App\Notifications\AccountNotification;
use Illuminate\Support\Facades\DB;

class ReferralCommisionService
{
    protected User $user;
    protected float $amount;
    protected int $userId;
    protected int $level;

    public function __construct(User $user, float $amount)
    {
        $this->user = $user;
        $this->amount = $amount;
        $this->level = 0;
    }


    public function run(): void
    {
        if (!empty($this->user->ref_by) && DB::table('users')->where('id', $this->user->ref_by)->exists()) {
            $this->creditDirectReferral();
            $this->creditDownline($this->amount, $this->user->id, $this->level);
        }
    }

    public function creditDirectReferral(): void
    {
        $settings = Settings::where('id', '=', '1')->select('id', 'referral_commission', 'currency')->first();
        $earnings = $settings->referral_commission * $this->amount / 100;
        $referral = User::where('id', $this->user->ref_by)->first();

        $ref = DB::table('users')->where('id', $this->user->ref_by)->first();
        $ref->increment('account_bal', $earnings);
        $ref->increment('ref_bonus', $earnings);

        $referral->notify(new AccountNotification("You just got a referral bonus. Amount: {$settings->currency}{$earnings} from {$this->user->name}", 'Referral Bonus'));
        //create history
        $this->createHistory($referral->id, $earnings);
    }

    // static function to calculate the referral commission
    public function creditDownline(float $amount, int $userId = 0, int $level = 0): void
    {
        $referedMembers = '';

        $users = User::select(['id', 'account_bal', 'ref_bonus'])->get();
        $settings = Settings::where('id', '=', '1')->first();
        $parent = User::where('id', $userId)->select(['ref_by'])->first();


        $users->each(function ($user) use ($level, $parent, $amount, $referedMembers, $settings) {

            if ($user->id == $parent->ref_by) {

                if ($level == 1) {
                    $earnings = $settings->referral_commission1 * $amount / 100;
                    //add earnings to ancestor balance
                    User::where('id', $user->id)
                        ->update([
                            'account_bal' => $user->account_bal + $earnings,
                            'ref_bonus' => $user->ref_bonus + $earnings,
                        ]);

                    User::where('id', $user->id)->first()->notify(new AccountNotification("You just got an indirect level 1 referral bonus. Amount: {$settings->currency}{$earnings}. Visit the referral page for more info", 'Referral Bonus'));

                    $this->createHistory($user->id, $earnings);
                } elseif ($level == 2) {
                    $earnings = $settings->referral_commission2 * $amount / 100;
                    //add earnings to ancestor balance
                    User::where('id', $user->id)
                        ->update([
                            'account_bal' => $user->account_bal + $earnings,
                            'ref_bonus' => $user->ref_bonus + $earnings,
                        ]);

                    User::where('id', $user->id)->first()->notify(new AccountNotification("You just got an indirect level 2 referral bonus. Amount: {$settings->currency}{$earnings}. Visit the referral page for more info", 'Referral Bonus'));

                    $this->createHistory($user->id, $earnings);
                } elseif ($level == 3) {
                    $earnings = $settings->referral_commission3 * $amount / 100;
                    //add earnings to ancestor balance
                    User::where('id', $user->id)
                        ->update([
                            'account_bal' => $user->account_bal + $earnings,
                            'ref_bonus' => $user->ref_bonus + $earnings,
                        ]);
                    User::where('id', $user->id)->first()->notify(new AccountNotification("You just got an indirect level 3 referral bonus. Amount: {$settings->currency}{$earnings}. Visit the referral page for more info", 'Referral Bonus'));

                    $this->createHistory($user->id, $earnings);
                } elseif ($level == 4) {
                    $earnings = $settings->referral_commission4 * $amount / 100;
                    //add earnings to ancestor balance
                    User::where('id', $user->id)
                        ->update([
                            'account_bal' => $user->account_bal + $earnings,
                            'ref_bonus' => $user->ref_bonus + $earnings,
                        ]);
                    User::where('id', $user->id)->first()->notify(new AccountNotification("You just got an indirect level 4 referral bonus. Amount: {$settings->currency}{$earnings}. Visit the referral page for more info", 'Referral Bonus'));

                    $this->createHistory($user->id, $earnings);
                } elseif ($level == 5) {
                    $earnings = $settings->referral_commission5 * $amount / 100;
                    //add earnings to ancestor balance
                    User::where('id', $user->id)
                        ->update([
                            'account_bal' => $user->account_bal + $earnings,
                            'ref_bonus' => $user->ref_bonus + $earnings,
                        ]);

                    User::where('id', $user->id)->first()->notify(new AccountNotification("You just got an indirect level 5 referral bonus. Amount: {$settings->currency}{$earnings}. Visit the referral page for more info", 'Referral Bonus'));

                    $this->createHistory($user->id, $earnings);
                }

                if ($level == 6) {
                    return false;
                }

                $referedMembers .= $this->creditDownline($amount, $user->id, $level + 1);
            }
        });
    }

    // save transaction history
    private function createHistory(int $userId, float $amount, string $type = 'Ref_bonus', string $narration = 'Credit'): void
    {
        Tp_Transaction::create([
            'user' => $userId,
            'plan' => $narration,
            'amount' => $amount,
            'type' => $type,
        ]);
    }
}
