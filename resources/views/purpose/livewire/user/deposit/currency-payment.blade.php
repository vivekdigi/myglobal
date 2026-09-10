<div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if ($payment_mode->name == 'Bank Transfer' || $payment_mode->defaultpay != 'yes')
                        <div class="row">
                            <div class="col-lg-8 offset-lg-2">
                                @if (!empty($payment_mode->bankname))
                                    <div class="mb-3">
                                        <h5 class="m-0">Bank Name</h5>
                                        <input type="text" class="form-control readonly mt-2"
                                            value="{{ $payment_mode->bankname }}" readonly>
                                    </div>
                                @endif
                                @if (!empty($payment_mode->account_name))
                                    <div class="mb-3">
                                        <h5 class="m-0">Account Name</h5>
                                        <input type="text" class="form-control readonly mt-2"
                                            value="{{ $payment_mode->account_name }}" readonly>
                                    </div>
                                @endif
                                @if (!empty($payment_mode->account_number))
                                    <div class="mb-3">
                                        <h5 class="m-0">Account Number</h5>
                                        <input type="text" class="form-control readonly mt-2"
                                            value="{{ $payment_mode->account_number }}" readonly>
                                    </div>
                                @endif
                                @if (!empty($payment_mode->swift_code))
                                    <div class="mb-3">
                                        <h5 class="m-0">Swift Code</h5>
                                        <input type="text" class="form-control readonly mt-2"
                                            value="{{ $payment_mode->swift_code }}" readonly>
                                    </div>
                                @endif
                                <div>
                                    @include('livewire.user.deposit.submit-payment')
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-lg-8 offset-lg-2">
                            @if ($payment_mode->name == 'Credit Card')
                                @if ($settings->credit_card_provider == 'Paystack')
                                    @include('livewire.user.deposit.paystack-payment')
                                @endif
                                @if ($settings->credit_card_provider == 'Flutterwave')
                                    @include('livewire.user.deposit.flutterwave-payment')
                                @endif
                                @if ($settings->credit_card_provider == 'Stripe')
                                    @include('livewire.user.deposit.stripe-payment')
                                @endif
                            @endif
                            @if ($payment_mode->name == 'Paypal')
                                @include('livewire.user.deposit.paypal-payment')
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
