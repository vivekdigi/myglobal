<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CryptoAccount;
use Illuminate\Support\Facades\Auth;
use App\Models\SettingsCont;
use App\Models\Settings;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\CryptoRecord;
use App\Models\Binary_stake_records;
use App\Traits\Apitrait;
use App\Traits\TemplateTrait;

class BinaryTradingController extends Controller
{
    use Apitrait, TemplateTrait;

    public function moduleView()
    {

        return view("user.binary.view", [
            'title' =>  'Smart Trader',
            'cbalance' => CryptoAccount::where('user_id', Auth::user()->id)->first(),
        ]);
    }

    public function stakeHandle(Request $request)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'amount' => 'required|numeric',
            'duration' => 'required',
            'action' => 'required|min:2',
        ]);

        // Create a new FormData instance and fill it with the validated data
        $formData = new Binary_stake_records();
        $formData->amount = $validatedData['amount'];
        $formData->duration = $validatedData['duration'];
        $formData->direction = $validatedData['action'];

        // Save the form data to the database
        $formData->save();

        // Return a response or perform additional actions as needed
        return response()->json(['message' => 'Form data submitted successfully']);
    }

}
