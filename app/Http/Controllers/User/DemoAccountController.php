<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\DemoAccountRequestMail;
use App\Models\DemoAccountRequest;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class DemoAccountController extends Controller
{
    public function requestDemo(Request $request)
    {
        try {
            $user     = Auth::user();
            $settings = Settings::find(1);

            // Prevent duplicate requests
            $existing = DemoAccountRequest::where('user_id', $user->id)->first();
            if ($existing) {
                return response()->json([
                    'success' => false,
                    'message' => 'You have already submitted a demo account request.',
                ], 409);
            }

            // Save to DB
            DemoAccountRequest::create([
                'user_id'    => $user->id,
                'user_name'  => $user->name,
                'user_email' => $user->email,
                'status'     => 'pending',
            ]);

            // Send email to super admin via contact_email (same as all other controllers)
            $adminEmail = $settings->contact_email ?? config('mail.from.address');

            Mail::to($adminEmail)->send(new DemoAccountRequestMail(
                $user->name,
                $user->email,
                $user->id,
                $user->accountid ?? 'N/A'
            ));

            return response()->json([
                'success' => true,
                'message' => 'Your request has been submitted successfully. Our team will contact you shortly.',
            ]);

        } catch (\Exception $e) {
            \Log::error('Demo account request failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again or contact support.',
                'error'   => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }
}