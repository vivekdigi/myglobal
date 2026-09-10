{{-- blade-formatter-disable --}}
@component('mail::message')
# Hello {{ $invoice->user->name }}

@if ($invoice->status == 'paid')
    
Your invoice with {{ $settings->currency }}{{ $invoice->amount }} for trading account {{ $invoice->account->mt4_id }} have been paid. Thank you for your payment.
    
@endif

@if ($invoice->status == 'Unpaid')
Your invoice with {{ $settings->currency }}{{ $invoice->amount }} for trading account {{ $invoice->account->mt4_id }} is still unpaid. Please make payment to continue trading.
@component('mail::button', ['url' => route('acnt.invoice')])
Pay now
@endcomponent
@endif

@if ($invoice->status == 'Created')
You have a new invoice for trading account: {{ $invoice->account->mt4_id }} <br>
Amount: {{ $settings->currency }}{{ $invoice->amount }}. <br>
Please make payment to continue trading.
@component('mail::button', ['url' => route('invoice')])
Pay now
@endcomponent
@endif

@if ($invoice->status == 'Expired')
Your invoice with {{ $settings->currency }}{{ $invoice->amount }} for trading account {{ $invoice->account->mt4_id }} has expired. Please make payment to continue trading. Note that your trading account have been undeployed from our server until you make payment.
@endif

Thanks,<br>
{{ config('app.name') }}
@endcomponent
{{-- blade-formatter-disable --}}
