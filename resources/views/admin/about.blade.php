@extends('layouts.app')
@section('content')
    <x-admin.alert />
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-home-tab" data-toggle="pill" data-target="#pills-home"
                                type="button" role="tab" aria-controls="pills-home"
                                aria-selected="true">General</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-profile-tab" data-toggle="pill" data-target="#pills-profile"
                                type="button" role="tab" aria-controls="pills-profile"
                                aria-selected="false">Environment</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-contact-tab" data-toggle="pill" data-target="#pills-contact"
                                type="button" role="tab" aria-controls="pills-contact" aria-selected="false">
                                Cache Management
                            </button>
                        </li>
                        {{-- <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-cleanup-tab" data-toggle="pill" data-target="#pills-cleanup"
                                type="button" role="tab" aria-controls="pills-cleanup" aria-selected="false">
                                System Cleanup
                            </button>
                        </li> --}}
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                            aria-labelledby="pills-home-tab">
                            <h1 class="title1">About Onlintrader Software</h1>
                            <p class="title1">Current Version: 5.0</p>

                            <div class="mt-1">
                                <a href="https://getonlinetrader.com/doc/help-desk" target="_blank" class="btn btn-primary">
                                    Software
                                    documentation</a>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                            <livewire:admin.platform.production-setup />
                        </div>
                        <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                            <livewire:admin.platform.caches>
                        </div>
                        <div class="tab-pane fade" id="pills-cleanup" role="tabpanel" aria-labelledby="pills-cleanup-tab">
                            ...
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
