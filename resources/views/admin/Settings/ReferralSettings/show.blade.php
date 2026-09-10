@extends('layouts.app')
@section('content')
    <div class="mt-2 mb-4">
        <h1 class="title1">Referral/Other Bonus Settings</h1>
    </div>
    <x-admin.alert />
    <div class="row">
        <div class="col-12">
            <div class="card p-md-5 p-2 shadow-lg ">
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a href="#dep" class="nav-link active" data-toggle="tab">Referral Bonus</a>
                    </li>
                    <li class="nav-item">
                        <a href="#with" class="nav-link" data-toggle="tab">Other Bonus(s)</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="dep">
                        @include('admin.Settings.ReferralSettings.referral')
                    </div>
                    <div class="tab-pane fade" id="with">
                        @include('admin.Settings.ReferralSettings.other-bonus')
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        // Submit email preference form
        $('#refform').on('submit', function() {
            //alert('love');
            $.ajax({
                url: "{{ route('updaterefbonus') }}",
                type: 'POST',
                data: $('#refform').serialize(),
                success: function(response) {
                    if (response.status === 200) {
                        $.notify({
                            // options
                            icon: 'flaticon-alarm-1',
                            title: 'Success',
                            message: response.success,
                        }, {
                            // settings
                            type: 'success',
                            allow_dismiss: true,
                            newest_on_top: false,
                            placement: {
                                from: "top",
                                align: "right"
                            },
                            offset: 20,
                            spacing: 10,
                            z_index: 1031,
                            delay: 5000,
                            timer: 1000,
                            animate: {
                                enter: 'animated fadeInDown',
                                exit: 'animated fadeOutUp'
                            },

                        });
                    } else {

                    }
                },
                error: function(error) {
                    console.log(error);
                },
            });
        });

        $('#bonusform').on('submit', function() {
            //alert('love');
            $.ajax({
                url: "{{ route('otherbonus') }}",
                type: 'POST',
                data: $('#bonusform').serialize(),
                success: function(response) {
                    if (response.status === 200) {
                        $.notify({
                            // options
                            icon: 'flaticon-alarm-1',
                            title: 'Success',
                            message: response.success,
                        }, {
                            // settings
                            type: 'success',
                            allow_dismiss: true,
                            newest_on_top: false,
                            placement: {
                                from: "top",
                                align: "right"
                            },
                            offset: 20,
                            spacing: 10,
                            z_index: 1031,
                            delay: 5000,
                            timer: 1000,
                            animate: {
                                enter: 'animated fadeInDown',
                                exit: 'animated fadeOutUp'
                            },

                        });
                    } else {

                    }
                },
                error: function(error) {
                    console.log(error);
                },
            });
        });
    </script>
@endpush
