<div class="text-center py-5">
    @php
        $payamount = $amount * 100;
    @endphp
    <form method="POST" action="{{ route('pay.paystack') }}" accept-charset="UTF-8" class="form-horizontal" role="form">
        <input type="hidden" name="email" value="{{ Auth::user()->email }}">
        <input type="hidden" name="amount" value="{{ $payamount }}">
        <input type="hidden" name="currency" value="{{ $settings->s_currency }}">
        <input type="hidden" name="metadata" value="{{ json_encode($array = ['key_name' => 'value']) }}">
        <input type="hidden" name="reference" value="{{ Paystack::genTranxRef() }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <button class="py-2 btn btn-primary" type="submit" value="Pay Now!">
            <i class="bi bi-credit-card"></i>
            Pay with Paystack
        </button>
    </form>
</div>
