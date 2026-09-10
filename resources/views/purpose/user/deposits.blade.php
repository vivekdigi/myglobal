@extends('layouts.dash')
@section('title', $title)
@section('content')
    <!-- Page title -->
    <div class="page-title">
        <div class="row justify-content-between align-items-center">
            <div class="mb-3 col-md-6 mb-md-0">
                <h5 class="mb-0 text-white h3 font-weight-400">Fund your account balance</h5>
            </div>
        </div>
    </div>
    <x-danger-alert />
    <x-success-alert />
    <div class="row"> 
        <div class="col-md-12" style="padding-top:20px">
            @if ($settings->enable_annoc == 'on' and !empty($settings->newupdate))
                <div class="row 22222">
                <div class="col-12">
                <div class="py-4 alert alert-info alert-dismissible fade show" role="alert">
                    {{ $settings->newupdate }} <span class="offer-text">Offer</span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                </div>
                </div>
            @endif
            <div class="card ">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <form action="javascript:;" method="post" id="submitpaymentform">
                                @csrf
                                <div class="row">
                                    <div class="mb-4 col-md-12">
                                        <h5 class="card-title ">Enter Amount</h5>
                                        <input class="form-control " placeholder="Enter Amount"
                                            min="{{ $moresettings->minamt }}" type="number" name="amount" required>
                                    </div>
                                    <div class="mb-4 col-md-12">
                                        <input type="hidden" name="payment_method" id="paymethod">
                                    </div>
                                    <div class="mt-2 mb-1 col-md-12">
                                        <h5 class="card-title ">Choose Payment Method from the list below</h5>
                                    </div>
                                    @forelse ($dmethods as $method)
                                        <div class="mb-2 col-md-6">
                                            <a style="cursor: pointer;" data-method="{{ $method->name }}"
                                                id="{{ $method->id }}" class="text-decoration-none"
                                                onclick="checkpamethd(this.id)">
                                                <div class="rounded border">
                                                    <div
                                                        class="card-body d-flex justify-content-between align-items-center">
                                                        <span class="  {{  $method->name }}">
                                                            
                                                            @if (!empty($method->img_url))
                                                                <img src="{{ $method->img_url }}" alt=""
                                                                    class="" style="width: 25px;">
                                                            @endif
                                                            {{ $method->name }}
                                                        </span>
                                                        <span>
                                                            <input type="radio" id="{{ $method->id }}customCheck1"
                                                                readonly>
                                                        </span>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    @empty
                                        <div class="mb-1 col-md-12">
                                            <p class="">No Payment Method enabled at the moment, please check
                                                back later.</p>
                                        </div>
                                    @endforelse
                                    @if (count($dmethods) > 0)
                                        <div class="mt-2 mb-1 col-md-12">
                                            <input type="submit" class="px-5 btn btn-primary btn-lg"
                                                value="Procced to Payment">
                                        </div>
                                        <input type="hidden" id="lastchosen" value="0">
                                    @endif
                                </div>
                            </form>
                        </div>
                        <div class="mt-4 col-md-4">
                            <!-- Seller -->
                            <div class="card">

                                <div class="card-body">
                                    <div class="pb-4">
                                        <div class="row align-items-center">
                                            <div class="col-6">
                                                <h6 class="mb-0">Total Deposit</h6>
                                                <span class="text-sm text-muted">-</span>
                                            </div>
                                            <div class="col-6">
                                                <h6 class="mb-1">
                                                    <b>{{ $settings->currency }}{{ number_format($deposited, 2, '.', ',') }}
                                                    </b>
                                                </h6>
                                                <span class="text-sm text-muted">Amount</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="actions d-flex justify-content-between">
                                        <a href="{{ route('accounthistory') }}" class="action-item">
                                            <span class="btn-inner--icon">View deposit history</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @section('scripts')
        @parent
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <!-- Bootstrap Notify -->
        <script src="{{ asset('dash2/libs/bootstrap-notify/bootstrap-notify.min.js') }} "></script>

        @include('purpose.user.script')

    @endsection
@endsection
<style>
    .offer-popup {
    position: fixed;
    bottom: 30px;
    right: 30px;
    background: rgba(0, 0, 0, 0.9);
    color: #FFD700; /* gold text */
    border-radius: 15px;
    padding: 15px 25px;
    box-shadow: 0 0 15px rgba(255, 215, 0, 0.5);
    font-weight: 600;
    font-size: 16px;
    max-width: 280px;
    z-index: 9999;
    animation: fadeInUp 1s ease, blinkGlow 2s infinite alternate;
    transition: all 0.4s ease;
}

/* Close button styling */
.offer-popup .close {
    color: #FFD700;
    opacity: 0.8;
    font-size: 22px;
    font-weight: bold;
    position: absolute;
    top: 5px;
    right: 10px;
}

.offer-popup .close:hover {
    opacity: 1;
}

/* Blinking gold glow */
@keyframes blinkGlow {
    0% { box-shadow: 0 0 10px rgba(255, 215, 0, 0.5); }
    100% { box-shadow: 0 0 25px rgba(255, 215, 0, 1); }
}

/* Slide-up entrance animation */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.offer-text {
    background: #d68106;
    color: #fff;
    padding: 6px 14px;
    border-radius: 18px;
    font-size: 14px;
    margin-left: 6px;
    animation: pulseText 1.5s infinite;
}
/* .text-warning {
    color: #d6940d !important;
}
.bg-dark {
    background-color: #000000eb !important;
} */
/* Subtle blinking text effect */
@keyframes pulseText {
    0% { opacity: 1; }
    50% { opacity: 0.5; }
    100% { opacity: 1; }
}
</style>