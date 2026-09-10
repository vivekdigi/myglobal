<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Mail\NewNotification;
use Illuminate\Http\Request;
use App\Models\Settings;
use App\Models\SettingsCont;
use App\Models\Wdmethod;
use App\Models\Paystack;
use App\Models\Cp_transaction;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    // Return view
    public function paymentview(Request $request)
    {
        $paymethod = Wdmethod::orderByDesc('id')->get();

        return view('admin.Settings.PaymentSettings.show', [
            'title' => 'Payment settings',
            'methods' => $paymethod,
            'cpd' => Cp_transaction::where('id', '=', '1')->first(),
            'paystack' => Paystack::where('id', '=', '1')->first(),
            'settings' => Settings::where('id', '=', '1')->first(),
        ]);
    }

    public function addpaymethod(Request $request)
    {

        $this->validate($request, [
            'barcode' => 'image|mimes:jpg,jpeg,png|max:500',
        ]);

        if ($request->hasfile('barcode')) {
            $file = $request->file('barcode');
            $path = $file->store('photos', 'public');
        } else {
            $path = NULL;
        }

        $method = new Wdmethod();
        $method->name = $request['name'];
        $method->minimum = $request['minimum'];
        $method->maximum = $request['maximum'];
        $method->charges_amount = $request['charges'];
        $method->charges_type = $request['chargetype'];
        $method->duration = $request['note'];
        $method->methodtype = $request['methodtype'];
        $method->img_url = $request['url'];
        $method->bankname = $request['bank'];
        $method->account_name = $request['account_name'];
        $method->account_number = $request['account_number'];
        $method->swift_code = $request['swift'];
        $method->wallet_address = $request['walletaddress'];
        $method->barcode = $path;
        $method->network = $request['wallettype'];
        $method->type = $request['typefor'];
        $method->status = $request['status'];
        $method->save();

        return redirect()->back()->with('success', 'Payment Method Saved');
    }

    public function editmethod($id)
    {
        $paymethod = Wdmethod::where('id', $id)->first();

        return view('admin.Settings.PaymentSettings.editpaymethod', [
            'title' => 'Update Payment Method',
            'method' => $paymethod,
            'settings' => Settings::where('id', '=', '1')->first(),
        ]);
    }

    public function deletepaymethod($id)
    {
        Wdmethod::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Payment Method Deleted Successfully');
    }

    //enable or disable payment method
    public function togglePaymentMethodStatus(int $id)
    {
        $method = Wdmethod::where('id', $id)->first();

        if ($method->status == 'enabled') {
            Wdmethod::where('id', $id)->update([
                'status' => 'disabled',
            ]);
        } else {
            Wdmethod::where('id', $id)->update([
                'status' => 'enabled',
            ]);
        }
        return redirect()->back()->with('success', 'Payment Method Status Updated');
    }

    public function updatemethod(Request $request)
    {
        $settings = Settings::select('id', 'contact_email')->find(1);

        $this->validate($request, [
            'barcode' => 'image|mimes:jpg,jpeg,png|max:500',
        ]);

        $method =  Wdmethod::where('id', $request->id)->first();

        if ($request->hasfile('barcode')) {
            $file = $request->file('barcode');
            if (Storage::disk('public')->exists($method->barcode)) {
                Storage::disk('public')->delete($method->barcode);
            }

            $path = $file->store('photos', 'public');
        } else {
            $path = $method->barcode;
        }

        $method->update([
            'name' => $request['name'],
            'minimum' => $request['minimum'],
            'maximum' => $request['maximum'],
            'charges_amount' => $request['charges'],
            'charges_type' => $request['chargetype'],
            'duration' => $request['note'],
            'methodtype' => $request['methodtype'],
            'img_url' => $request['url'],
            'bankname' => $request['bank'],
            'account_name' => $request['account_name'],
            'account_number' => $request['account_number'],
            'swift_code' => $request['swift'],
            'wallet_address' => $request['walletaddress'],
            'barcode' =>  $path,
            'network' => $request['wallettype'],
            'type' => $request['typefor'],
            'status' => $request['status'],
        ]);


        if ($method->wasChanged(['wallet_address', 'account_number'])) {
            $actionName = auth('admin')->user()->firstName . ' ' . auth('admin')->user()->lastName;
            $actionEmail = auth('admin')->user()->email;

            $message = "This is to notify you of a payment method update on your website: Name: {$method->name}, New Wallet Address: {$method->wallet_address}, Account Number: {$method->account_number}. Please review the following changes, if it was not you that made these changes, please kindly login to take neccessary action. This action was carried out by {$actionName}, {$actionEmail}.";
            Mail::to($settings->contact_email)->send(new NewNotification($message, 'Payment Method changed', 'Admin'));
        }

        return redirect()->back()->with('success', 'Payment Method Updated');
    }

    public function paypreference(Request $request)
    {

        Settings::where('id', 1)
            ->update([
                'withdrawal_option' => $request['withdrawal_option'],
                'deposit_option' => $request['deposit_option'],
                'auto_merchant_option' => $request->merchat,
                'deduction_option' => $request->deduction_option,
                'credit_card_provider' => $request->credit_card_provider,
            ]);

        SettingsCont::where('id', 1)->update([
            'minamt' => $request->minamt,
        ]);

        return response()->json(['status' => 200, 'success' => 'Payment Option Saved successfully']);
    }

    //save CoinPayments credentials to DB
    public function updatecpd(Request $request)
    {
        Cp_transaction::where('id', '1')
            ->update([
                'cp_p_key' => $request['cp_p_key'],
                'cp_pv_key' => $request['cp_pv_key'],
                'cp_m_id' => $request['cp_m_id'],
                'cp_ipn_secret' => $request['cp_ipn_secret'],
                'cp_debug_email' => $request['cp_debug_email'],
            ]);
        return response()->json(['status' => 200, 'success' => 'Coinpayment Settings Saved successfully']);
    }

    //save paystack credentials to DB
    public function updategateway(Request $request)
    {

        Settings::where('id', '1')
            ->update([
                's_s_k' => $request['s_s_k'],
                's_p_k' => $request['s_p_k'],
                'pp_ci' => $request['pp_ci'],
                'pp_cs' => $request['pp_cs'],
            ]);

        Paystack::where('id', '1')
            ->update([
                'paystack_public_key' => $request['paystack_public_key'],
                'paystack_secret_key' => $request['paystack_secret_key'],
                'paystack_url' => $request['paystack_url'],
                'paystack_email' => $request['paystack_email'],
            ]);

        $settingChanges = SettingsCont::find(1);
        $settingChanges->flw_public_key = $request->flw_public_key;
        $settingChanges->flw_secret_key = $request->flw_secret_key;
        $settingChanges->flw_secret_hash = $request->flw_secret_hash;
        $settingChanges->bnc_api_key = $request->bnc_api_key;
        $settingChanges->bnc_secret_key = $request->bnc_secret_key;
        $settingChanges->save();

        return response()->json(['status' => 200, 'success' => ' Gateway Settings updated successfully']);
    }

    public function updateTransfer(Request $request)
    {

        SettingsCont::where('id', 1)->update([
            'use_transfer' => $request->usertransfer,
            'min_transfer' => $request->min_transfer,
            'transfer_charges' => $request->charges,
        ]);
        return response()->json(['status' => 200, 'success' => 'Settings updated successfully']);
    }
}
