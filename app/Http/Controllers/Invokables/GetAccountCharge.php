<?php

namespace App\Http\Controllers\Invokables;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Mt4Details;
use App\Models\Settings;
use App\Traits\PingServer;

class GetAccountCharge extends Controller
{
    use PingServer;
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        $settings = Settings::select('subscription_type')->find(1);

        if ($settings->subscription_type == 'Percentage') {

            $accounts = Mt4Details::where('status', 'Active')->get();

            $accounts->each(function (Mt4Details $account) {
                $response = $this->fetctApi('/account-commission/', [
                    'accountId' => $account->mt4_id,
                ]);

                if ($response->successful()) {
                    //create invoice 
                    $invoice = new Invoice();
                    $invoice->invoice_id = mt_rand(100000, 999999);
                    $invoice->user_id = $account->client_id;
                    $invoice->mt4_details_id = $account->id;
                    $invoice->amount = $response['commission_amount'];
                    $invoice->type = "Account charge";
                    $invoice->status = "Created";
                    $invoice->reminded_at = now()->addDay();
                    $invoice->save();
                }
                if ($response->failed()) {
                    logger()->error($response['message']);
                }
            });
        }
    }
}
