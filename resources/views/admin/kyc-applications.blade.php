@extends('layouts.app')
@section('content')
    <p>
        <a href="{{ route('kyc') }}">
            <i class="p-2 rounded-lg fa fa-arrow-circle-left fa-2x bg-light"></i>
        </a>
    </p>

    <div class="mt-2 mb-4 d-flex justify-content-between align-items-center">
        <div>
            <h1 class="title1 ">{{ $kyc->user->name }} KYC Application</h1>
            @if ($kyc->status == 'Verified')
                <span class="badge badge-success">Verified</span>
            @else
                <span class="badge badge-danger">{{ $kyc->status }}</span>
            @endif
        </div>
        <a href="#" data-toggle="modal" data-target="#action" class="btn btn-primary btn-sm">Action</a>
    </div>
    <div id="action" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header ">
                    <h3 class="mb-2 d-inline ">Process KYC</h3>
                    <button type="button" class="close " data-dismiss="modal" aria-h6="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body ">
                    <form action="{{ route('processkyc') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <select name="action" id="vefyuser" class="form-control  " required>
                                <option value="">Choose one</option>
                                <option value="Accept">Accept and verify user</option>
                                <option value="Reject">Reject and remain unverified</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <textarea name="message" placeholder="Enter Message " class="form-control  " required></textarea>
                        </div>
                        <div class="form-group">
                            <h5 class="">Email subject</h5>
                            <input type="text" name="subject" id="" class="form-control  "
                                placeholder="Account is verified successfully" required>
                        </div>
                        <input type="hidden" name="kyc_id" value="{{ $kyc->id }}">
                        <div class="form-group">
                            <button type="submit" class="px-4 btn btn-primary"> Confirm </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <x-admin.alert />
    <div class="mb-5 row">
        <div class="col-md-12">
            <div class="card p-md-4 p-2 ">
                <div class="card-body">
                    <div class="row">
                        <div class="mb-3 col-md-12 border-bottom">
                            <small class="text-primary">Personal Information</small>
                        </div>
                        <div class="mb-3 col-md-6">
                            <h2 class="">{{ $kyc->first_name }}</h2>
                            <small class="text-muted">First name</small>
                        </div>
                        <div class="mb-3 col-md-6">
                            <h2 class="">{{ $kyc->last_name }}</h2>
                            <small class="text-muted">Last name</small>
                        </div>
                        <div class="mb-3 col-md-6">
                            <h2 class="">{{ $kyc->email }}</h2>
                            <small class="text-muted">Email</small>
                        </div>
                        <div class="mb-3 col-md-6">
                            <h2 class="">{{ $kyc->phone_number }}</h2>
                            <small class="text-muted">Phone Number</small>
                        </div>
                        <div class="mb-3 col-md-6">
                            <h2 class="">{{ $kyc->dob }}</h2>
                            <small class="text-muted">Date of Birth</small>
                        </div>
                        <div class="mb-3 col-md-6">
                            <h2 class="">{{ $kyc->social_media }}</h2>
                            <small class="text-muted">Social Media username</small>
                        </div>
                        <div class="my-3 border-bottom col-md-12">
                            <small class="text-primary">Address Information</small>
                        </div>

                        <div class="mb-3 col-md-6">
                            <h2 class="">{{ $kyc->address }}</h2>
                            <small class="text-muted">Address Line</small>
                        </div>
                        <div class="mb-3 col-md-6">
                            <h2 class="">{{ $kyc->city }}</h2>
                            <small class="text-muted">City</small>
                        </div>
                        <div class="mb-3 col-md-6">
                            <h2 class="">{{ $kyc->state }}</h2>
                            <small class="text-muted">State</small>
                        </div>
                        <div class="mb-3 col-md-6">
                            <h2 class="">{{ $kyc->country }}</h2>
                            <small class="text-muted">Nationality</small>
                        </div>
                        <div class="my-3 border-bottom col-md-12">
                            <small class="text-primary">Document Information</small>
                        </div>
                        <div class="mb-5 col-md-12">
                            <h2 class="">{{ $kyc->document_type }}</h2>
                            <small class="text-muted">Document type</small>
                        </div>
                        <div class="mb-3 col-md-6">
                            <img src="{{ asset('/' . $kyc->frontimg) }}" alt=""
                                class="w-50 img-fluid d-block">
                            <small class="text-muted">Front View of Document</small>
                        </div>
                        <div class="mb-3 col-md-6">
                            <img src="{{ asset('/' . $kyc->backimg) }}" alt=""
                                class="w-50 img-fluid d-block">
                            <small class="text-muted">Back View of Document</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script>
$(document).ready(function () {

    $('#vefyuser').on('change', function () {
        var value = $(this).val();

        if (value === "Accept") {
            $('textarea[name="message"]').val(
                "This is to inform you that with following documents which you submitted for KYC, your account has been verified. You can now enjoy all our services without restrictions. Cheers!!!"
            );
        }

        if (value === "Reject") {
            $('textarea[name="message"]').val(
                "This is to inform you that with following documents which you submitted for KYC, your account has been not verified. Kindly resubmit the document or email your document by email."
            );
        }

    });

});
</script>
@endpush