{{-- blade-formatter-disable --}}
@component('mail::message')
# Dear {{$user->name}}, 

We are really excited to welcome you to  community. <br>
Thank you for joining {{$settings->site_name}} – your trusted FX broker for secure, fast, and reliable trading.<br>
This is your first step toward becoming a successful trader in a platform designed with simplicity, transparency, and performance in mind.<br> <br>
We are dedicated to building strong partnerships and mutual growth. <br>
Our expert support team is here to assist you at every step. Please don't hesitate to reach out if you need help or guidance.<br>

Kindly begin your trading journey using the details below:<br></br>

@if(!empty($accountType))
Account Type: <strong>{{ $accountType }}</strong><br>
@endif
Login: {{$user->accountid}} <br>
Investor Password: <strong>{{ $account->investor_password ?? 'N/A' }}</strong><br>
Master Password: <strong>{{ $account->master_password ?? 'N/A' }}</strong><br>
Broker Name: Majestyfx<br>
Server: Majestyfx-Trade<br><br>
You can download the MT5 app from the App Store , or directly from our website <br> </br>
<strong>Make a Deposit and start your trading journey , for client area login click here <a href="https://my.majestiglobal.com/login">Login</a> </strong><br><strong>Your trading account will be Inactive if you do not log in within two (2) days of account creation. </strong>
<br> 
Important: We recommend logging in as soon as possible to keep your account active Or you can reach our WhatsApp customer support number @+44 7429 919408 or Email us at support@majestiglobal.com to make it active again.
<br>
We look forward to seeing you gain your financial desires.
</br>
Your experience is going to be nice and smooth. <br>
No frustrations, no trouble.
<br> <br>

Thanks and Regards,<br>
{{ config('app.name') }}
@endcomponent
{{-- blade-formatter-disable --}}
