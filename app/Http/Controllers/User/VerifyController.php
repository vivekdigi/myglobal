<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\KycApplicationRequest;
use App\Mail\NewNotification;
use App\Models\Kyc;
use App\Models\Settings;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
class VerifyController extends Controller
{
    //
    public function verifyaccount_old(KycApplicationRequest $request)
    {
        $user = Auth::user();
        $whitelist = array('jpeg', 'jpg', 'png');

        // filter front of document upload
        $frontimg = $request->file('frontimg');
        $backimg = $request->file('backimg');
        $backimgExtention = $backimg->extension();
        $extension = $frontimg->extension();

        if (!in_array($extension, $whitelist) or !in_array($backimgExtention, $whitelist)) {
            return redirect()->back()
                ->with('message', 'Unaccepted Image Uploaded, please make sure to upload the correct document.');
        }

        // upload documents to storage
        $frontimgPath = $frontimg->store('uploads', 'public');
        $backimgPath = $backimg->store('uploads', 'public');

        $kyc = new Kyc();
        $kyc->first_name = $request->first_name;
        $kyc->last_name = $request->last_name;
        $kyc->email = $request->email;
        $kyc->phone_number = $request->phone_number;
        $kyc->dob = $request->dob;
        $kyc->social_media = $request->social_media ? $request->social_media : 'Not provided';
        $kyc->address = $request->address;
        $kyc->city = $request->city;
        $kyc->state = $request->state;
        $kyc->country = $request->country;
        $kyc->document_type = $request->document_type;
        $kyc->frontimg = $frontimgPath;
        $kyc->backimg = $backimgPath;
        $kyc->status = 'Under review';
        $kyc->user_id = $user->id;
        $kyc->save();


        //update user
        User::where('id', $user->id)
            ->update([
                'kyc_id' => $kyc->id,
                'account_verify' => 'Under review',
            ]);

        $settings = Settings::find(1);
        $message = "This is to inform you that $user->name just submitted a request for KYC(identity verification), please login your admin account to review and take neccessary action.";
        $subject = "Identity Verification Request from $user->name";
        $url = config('app.url') . '/admin/dashboard/kyc';
        //Mail::to($settings->contact_email)->send(new NewNotification($message, $subject, 'Admin', $url));

        return redirect()->back()->with('success', 'Action Sucessful! Please wait while we verify your application. You will receive an email regarding the status of your application.');
    }
    public function verifyaccount(KycApplicationRequest $request) {
        $user = Auth::user();
        $whitelist = ['jpeg', 'jpg', 'png'];
    
        $frontimg = $request->file('frontimg');
        $backimg = $request->file('backimg');
    
        $frontExt = $frontimg->extension();
        $backExt = $backimg->extension();
    
        if (!in_array($frontExt, $whitelist) || !in_array($backExt, $whitelist)) {
            return redirect()->back()
                ->with('message', 'Unaccepted Image Uploaded, please upload JPG, JPEG or PNG.');
        }
    
        // Set your custom public path
        $destinationPath = public_path('storage/uploads');
    
        // Ensure the directory exists
        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0755, true);
        }
    
        // Generate unique filenames
        $frontFileName = time() . '_front_' . Str::random(10) . '.' . $frontExt;
        $backFileName = time() . '_back_' . Str::random(10) . '.' . $backExt;
    
        // Move files to public path
        $frontimg->move($destinationPath, $frontFileName);
        $backimg->move($destinationPath, $backFileName);
    
        // Store relative paths in DB
        $frontimgPath = 'storage/uploads/' . $frontFileName;
        $backimgPath = 'storage/uploads/' . $backFileName;
    
        // Save KYC record
        $kyc = new Kyc();
        $kyc->first_name = $request->first_name;
        $kyc->last_name = $request->last_name;
        $kyc->email = $request->email;
        $kyc->phone_number = $request->phone_number;
        $kyc->dob = $request->dob;
        $kyc->social_media = $request->social_media ?: 'Not provided';
        $kyc->address = $request->address;
        $kyc->city = $request->city;
        $kyc->state = $request->state;
        $kyc->country = $request->country;
        $kyc->document_type = $request->document_type;
        $kyc->frontimg = $frontimgPath;
        $kyc->backimg = $backimgPath;
        $kyc->status = 'Under review';
        $kyc->user_id = $user->id;
        $kyc->save();
    
        // Update user
        $user->update([
            'kyc_id' => $kyc->id,
            'account_verify' => 'Under review',
        ]);
    
        // Send notification email (optional)
        $settings = Settings::find(1);
        $message = "This is to inform you that $user->name just submitted a request for KYC verification. Please review it.";
        $subject = "Identity Verification Request from $user->name";
        $url = config('app.url') . '/admin/dashboard/kyc';
    
        // Uncomment to send mail if needed
        Mail::to($settings->contact_email)->send(new NewNotification($message, $subject, 'Admin', $url));
    
        return redirect()->back()->with('success', 'Action successful! Your verification application has been submitted.');
    }
}
