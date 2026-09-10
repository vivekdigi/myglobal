@extends('layouts.millage')
@section('title', $title)
@section('styles')
    @parent
    <link rel="stylesheet" href="{{ asset('themes/purposeTheme/assets/css/style.css') }}" id="stylesheet">
@endsection

@section('content')
    <!-- Page title -->
    <div class="page-title">
        <div class="row justify-content-between align-items-center">
            <div class="mb-3 col-md-6 mb-md-0">
                <h5 class="mb-0  h3 font-weight-400">Get started with your investment.</h5>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <livewire:user.investment-plan />
                </div>
            </div>
        </div>
    </div>

@endsection
