@extends('layouts.app')
@section('content')
    <div class="mt-2 mb-3 d-inline">
        <h1 class="title1 d-inline mr-4">App Settings</h1>
    </div>
    <x-admin.alert />
    @if (count($errors) > 0)
        <div class="row">
            <div class="col-lg-12">
                <div class="alert alert-danger alert-dismissable" role="alert">
                    <button type="button" clsass="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    @foreach ($errors->all() as $error)
                        <i class="fa fa-warning"></i> {{ $error }}
                    @endforeach
                </div>
            </div>
        </div>
    @endif
    <div class="mt-2 mb-5 row">
        <div class="col-12">
            <div class="card p-md-5 p-2 shadow-lg ">
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a href="#module" class="nav-link active" data-toggle="tab">Modules</a>
                    </li>
                    <li class="nav-item">
                        <a href="#info" class="nav-link " data-toggle="tab">Website Information</a>
                    </li>
                    <li class="nav-item">
                        <a href="#pref" class="nav-link" data-toggle="tab">Preference</a>
                    </li>
                    <li class="nav-item">
                        <a href="#email" class="nav-link" data-toggle="tab">Email/Google Login-Captcha</a>
                    </li>
                    <li class="nav-item">
                        <a href="#display" class="nav-link" data-toggle="tab">Theme/Display</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="module">
                        <livewire:admin.software-module />
                    </div>
                    <div class="tab-pane fade" id="info">
                        @include('admin.Settings.AppSettings.webinfo')
                    </div>
                    <div class="tab-pane fade" id="pref">
                        @include('admin.Settings.AppSettings.webpreference')
                    </div>
                    <div class="tab-pane fade" id="email">
                        @include('admin.Settings.AppSettings.email')
                    </div>
                    <div class="tab-pane fade" id='display'>
                        @include('admin.Settings.AppSettings.theme')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $('#updatepreference').on('submit', function() {
            //alert('love');
            $.ajax({
                url: "{{ route('updatepreference') }}",
                type: 'POST',
                data: $('#updatepreference').serialize(),
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
    <script>
        $('.select2').select2();
        document.getElementById("themeForm").addEventListener('submit', function() {
            document.getElementById("themeBtn").disabled = true;
            var element = document.getElementById("loadingTheme");
            element.classList.remove("d-none");
        });

        function changecurr() {
            var e = document.getElementById("select_c");
            var selected = e.options[e.selectedIndex].id;
            document.getElementById("s_c").value = selected;
            console.log(selected);
        }
    </script>
    <script>
        let sendmail = document.querySelector('#sendmailserver');
        let smtp = document.querySelector('#smtpserver');
        let smtptext = document.querySelectorAll('.smtp');
        //console.log(sendmail);
        sendmail.addEventListener('click', sortform);
        smtp.addEventListener('click', sortform);

        if (smtp.checked) {
            smtptext.forEach(smtps => {
                smtps.classList.remove('d-none');
                smtps.setAttribute('required', '');
            });
        }

        function sortform() {
            if (sendmail.checked) {
                smtptext.forEach(element => {
                    element.classList.add('d-none');
                    element.removeAttribute('required', '');
                });
            }
            if (smtp.checked) {
                smtptext.forEach(smtps => {
                    smtps.classList.remove('d-none');
                    smtps.setAttribute('required', '');
                });
            }
        }

        // Submit email preference form
        $('#emailform').on('submit', function() {
            //alert('love');
            $.ajax({
                url: "{{ route('updateemailpreference') }}",
                type: 'POST',
                data: $('#emailform').serialize(),
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
