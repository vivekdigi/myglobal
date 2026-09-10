@extends('layouts.app')
@section('content')
    <div class="mt-2 mb-4">
        <h1 class="title1">Payment Settings Security</h1>
    </div>
    
    <div class="mb-5 row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card p-md-5 p-4 shadow-lg border-0" style="border-radius: 12px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                <div class="text-center mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center bg-light text-primary rounded-circle mb-3" style="width: 70px; height: 70px; font-size: 30px;">
                        <i class="flaticon-interface-5"></i>
                    </div>
                    <h3 class="font-weight-bold">Verify Identity</h3>
                    <p class="text-muted text-sm">
                        A 6-digit One-Time Password (OTP) has been sent to your registered email address. Please enter it below to proceed to Payment Settings.
                    </p>
                </div>

                @if(Session::has('message'))
                    <div class="alert alert-danger border-0 shadow-sm mb-4" role="alert">
                        <i class="flaticon-error-1 mr-2"></i>
                        {{ Session::get('message') }}
                    </div>
                @endif

                @if(Session::has('success'))
                    <div class="alert alert-success border-0 shadow-sm mb-4" role="alert">
                        <i class="flaticon-alarm-1 mr-2"></i>
                        {{ Session::get('success') }}
                    </div>
                @endif

                <form action="{{ route('admin.settings.payment.verify') }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    <div class="form-group mb-4">
                        <label for="otp" class="font-weight-bold text-dark">6-Digit OTP Code</label>
                        <input 
                            type="text" 
                            name="otp" 
                            id="otp" 
                            class="form-control text-center font-weight-bold @error('otp') is-invalid @enderror" 
                            placeholder="0 0 0 0 0 0" 
                            maxlength="6" 
                            pattern="\d{6}" 
                            required 
                            autofocus 
                            style="font-size: 24px; letter-spacing: 6px; height: 55px; border-radius: 8px;"
                        >
                        @error('otp')
                            <div class="invalid-feedback text-center mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary btn-block btn-lg font-weight-bold shadow-sm" style="height: 50px; border-radius: 8px;">
                        Verify Code
                    </button>
                </form>

                <div class="text-center mt-4">
                    <p class="text-muted mb-1 text-sm">Didn't receive the OTP?</p>
                    <a href="{{ route('admin.settings.payment.resend') }}" class="font-weight-bold text-primary text-decoration-none">
                        Resend New OTP
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
