<div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8 offset-lg-2" x-data="{
                            address: '{{ $payment_mode->wallet_address }}',
                            copyToClipboard(text) {
                                if (!navigator.clipboard) {
                                    return alert('Copying to clipboard only works on secure sites viewed through a modern browser.')
                                }
                                navigator.clipboard.writeText(text)
                                    .then(() => {
                                        var toastOptions = {
                                            'closeButton': false,
                                            'debug': false,
                                            'newestOnTop': false,
                                            'progressBar': false,
                                            'positionClass': 'toast-top-right',
                                            'preventDuplicates': false,
                                            'onclick': null,
                                            'showDuration': '300',
                                            'hideDuration': '1000',
                                            'timeOut': '5000',
                                            'extendedTimeOut': '1000',
                                            'showEasing': 'swing',
                                            'hideEasing': 'linear',
                                            'showMethod': 'fadeIn',
                                            'hideMethod': 'fadeOut'
                                        };
                                        Command: toastr['success']('Copied to clipboard', 'Success')
                                        toastr.options = toastOptions;
                                    })
                            },
                        }">
                            @if ($settings->deposit_option == 'manual')
                                @if (!empty($payment_mode->barcode))
                                    <div class="text-center">
                                        <p class="m-0">Scan the barcode below to make payment</p>
                                        <img src="{{ asset('storage/' . $payment_mode->barcode) }}" alt=""
                                            class="img-fluid w-25 m-0">
                                    </div>
                                @endif
                                <div class="mt-5">
                                    <p class="m-0">
                                        Or Send {{ $settings->currency }}{{ $amount }} to the
                                        address below
                                    </p>
                                    <div class="d-flex mt-2">
                                        <input id="key-02" class="form-control me-3"
                                            value="{{ $payment_mode->wallet_address }}" readonly>
                                        <div>
                                            <!-- Button -->
                                            <button class="clipboard btn btn-link px-0" data-clipboard-target="#key-02"
                                                data-bs-toggle="tooltip" data-bs-title="Copy to clipboard"
                                                x-on:click="copyToClipboard(address)">
                                                <i class="bi bi-clipboard fs-3"></i>
                                            </button>
                                        </div>

                                    </div>
                                    @if ($payment_mode->network)
                                        <small class="d-block mt-1">
                                            <strong>Network Type:</strong>
                                            {{ $payment_mode->network }}
                                        </small>
                                    @endif
                                </div>
                                @include('livewire.user.deposit.submit-payment')
                            @endif
                            @if ($settings->deposit_option != 'manual')
                                <div class="text-center py-4">
                                    @if (
                                        $payment_mode->name == 'USDT' &&
                                            $settings->auto_merchant_option == 'Binance' &&
                                            $settings->deposit_option == 'auto')
                                        <livewire:user.crypto-payment />
                                    @else
                                        <a href="{{ url('dashboard/cpay') }}/{{ $amount }}/{{ $coin }}/{{ Auth::user()->id }}/new"
                                            class="btn btn-primary">
                                            Pay Via Coinpayment
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
