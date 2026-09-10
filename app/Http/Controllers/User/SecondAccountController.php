<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\SecondAccountRequest;
use App\Models\Settings;
use App\Mail\NewNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class SecondAccountController extends Controller
{
    public function requestSecondAccount(Request $request)
    {
        try {
            $user     = Auth::user();
            $settings = Settings::find(1);

            // Prevent duplicate requests
            $existing = SecondAccountRequest::where('user_id', $user->id)->first();
            if ($existing) {
                return response()->json([
                    'success' => false,
                    'message' => 'You have already submitted a second account request.',
                ], 409);
            }

            // Save to DB
            SecondAccountRequest::create([
                'user_id'    => $user->id,
                'user_name'  => $user->name,
                'user_email' => $user->email,
                'status'     => 'pending',
            ]);

            // Send email to super admin
            $adminEmail = $settings->contact_email ?? config('mail.from.address');
            $adminUrl   = config('app.url') . '/admin/dashboard/second-account-requests';

            $body = "User <strong>{$user->name}</strong> (Email: {$user->email}, Account ID: " . ($user->accountid ?? 'N/A') . ") has submitted a <strong>Second Account Opening Request</strong>.<br><br>"
                  . "<a href='{$adminUrl}'>Click here to review the request</a>";

            Mail::to($adminEmail)->send(new NewNotification(
                $body,
                'New Second Account Request from ' . $user->name,
                'Admin'
            ));

            return response()->json([
                'success' => true,
                'message' => 'Your second account request has been submitted successfully. Our team will contact you shortly.',
            ]);

        } catch (\Exception $e) {
            \Log::error('Second account request failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again or contact support.',
                'error'   => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }
}
