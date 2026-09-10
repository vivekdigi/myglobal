@extends('layouts.app')
@section('content')
    <div class="mt-2 mb-4">
        <h1 class="title1 ">Terms and Privacy Policy</h1>
    </div>
    <x-admin.alert />
    <div class="mb-5 row">
        <div class="col-md-12">
            <div class="card p-1 p-md-5 shadow-lg  ">
                <div class="row">
                    <div class="mb-3 col-md-12">
                        <form method="post" action="{{ route('savetermspolicy') }}">
                            @csrf
                            <div class="form-group">
                                <h5 class="">Use Terms and Privacy Policy?</h5>
                                <div class="selectgroup">
                                    <label class="selectgroup-item">
                                        <input type="radio" name="terms" id="termsyes" value="yes"
                                            class="selectgroup-input" {{ $terms->useterms == 'yes' ? 'checked' : '' }}>
                                        <span class="selectgroup-button">Yes</span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="terms" id="termsno" value="no"
                                            class="selectgroup-input" {{ $terms->useterms == 'no' ? 'checked' : '' }}>
                                        <span class="selectgroup-button">No</span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <textarea class="ckeditor form-control  " name="termsprivacy">
                            {{ $terms->description }}
                        </textarea>
                            </div>
                            <div class="form-group">
                                <input type="submit" class="px-5 btn btn-primary btn-lg" value="Save">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="//cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.ckeditor').ckeditor();
        });
    </script>
@endpush
