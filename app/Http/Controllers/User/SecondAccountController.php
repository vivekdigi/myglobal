<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\SecondAccountRequest;
use App\Models\ThirdAccountRequest;
use App\Models\FourthAccountRequest;
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

            // Check minimum deposit requirement
            $totalDeposit = \App\Models\Deposit::where('user', $user->id)
                ->where('status', 'Processed')
                ->sum('amount');

            if ($totalDeposit < 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'Your deposit is too low to request a second account. Please make a deposit first.',
                ], 422);
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

    public function requestThirdAccount(Request $request)
    {
        try {
            $user     = Auth::user();
            $settings = Settings::find(1);

            // Prevent duplicate requests
            $existing = ThirdAccountRequest::where('user_id', $user->id)->first();
            if ($existing) {
                return response()->json([
                    'success' => false,
                    'message' => 'You have already submitted a third account request.',
                ], 409);
            }

            // Check minimum deposit requirement
            $totalDeposit = \App\Models\Deposit::where('user', $user->id)
                ->where('status', 'Processed')
                ->sum('amount');

            if ($totalDeposit < 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'Your deposit is too low to request a third account. Please make a deposit first.',
                ], 422);
            }

            // Save to DB
            ThirdAccountRequest::create([
                'user_id'    => $user->id,
                'user_name'  => $user->name,
                'user_email' => $user->email,
                'status'     => 'pending',
            ]);

            // Send email to super admin
            $adminEmail = $settings->contact_email ?? config('mail.from.address');
            $adminUrl   = config('app.url') . '/admin/dashboard/third-account-requests';

            $body = "User <strong>{$user->name}</strong> (Email: {$user->email}, Account ID: " . ($user->accountid ?? 'N/A') . ") has submitted a <strong>Third Account Opening Request</strong>.<br><br>"
                  . "<a href='{$adminUrl}'>Click here to review the request</a>";

            Mail::to($adminEmail)->send(new NewNotification(
                $body,
                'New Third Account Request from ' . $user->name,
                'Admin'
            ));

            return response()->json([
                'success' => true,
                'message' => 'Your third account request has been submitted successfully. Our team will contact you shortly.',
            ]);

        } catch (\Exception $e) {
            \Log::error('Third account request failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again or contact support.',
                'error'   => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    public function requestFourthAccount(Request $request)
    {
        try {
            $user     = Auth::user();
            $settings = Settings::find(1);

            // Prevent duplicate requests
            $existing = FourthAccountRequest::where('user_id', $user->id)->first();
            if ($existing) {
                return response()->json([
                    'success' => false,
                    'message' => 'You have already submitted a fourth account request.',
                ], 409);
            }

            // Check minimum deposit requirement
            $totalDeposit = \App\Models\Deposit::where('user', $user->id)
                ->where('status', 'Processed')
                ->sum('amount');

            if ($totalDeposit < 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'Your deposit is too low to request a fourth account. Please make a deposit first.',
                ], 422);
            }

            // Save to DB
            FourthAccountRequest::create([
                'user_id'    => $user->id,
                'user_name'  => $user->name,
                'user_email' => $user->email,
                'status'     => 'pending',
            ]);

            // Send email to super admin
            $adminEmail = $settings->contact_email ?? config('mail.from.address');
            $adminUrl   = config('app.url') . '/admin/dashboard/fourth-account-requests';

            $body = "User <strong>{$user->name}</strong> (Email: {$user->email}, Account ID: " . ($user->accountid ?? 'N/A') . ") has submitted a <strong>Fourth Account Opening Request</strong>.<br><br>"
                  . "<a href='{$adminUrl}'>Click here to review the request</a>";

            Mail::to($adminEmail)->send(new NewNotification(
                $body,
                'New Fourth Account Request from ' . $user->name,
                'Admin'
            ));

            return response()->json([
                'success' => true,
                'message' => 'Your fourth account request has been submitted successfully. Our team will contact you shortly.',
            ]);

        } catch (\Exception $e) {
            \Log::error('Fourth account request failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again or contact support.',
                'error'   => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }
}
