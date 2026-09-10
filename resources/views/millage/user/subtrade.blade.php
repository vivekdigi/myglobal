@php
    $sub_link = 'https://trade.mql5.com/trade';
@endphp

@extends('layouts.millage')
@section('title', $title)
@section('content')
    <!-- Page title -->
    <div class="page-title">
        <div class="row justify-content-between align-items-center">
            <div class="mb-3 col-md-6 mb-md-0">
                <h5 class="mb-0  h3 font-weight-400">Trading Account(s)</h5>
            </div>

        </div>
    </div>
    <x-danger-alert />
    <x-success-alert />
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="mb-5 row">
                        <div class="col-lg-8 offset-lg-2 p-lg-3 p-sm-5">
                            <h2 class="">{{ $settings->site_name }} Account manager</h2> <br>
                            <div clas="well">
                                <p class="text-justify ">Don’t have time to trade or learn how to
                                    trade?
                                    Our Account Management Service is The Best Profitable Trading Option for you,
                                    We can help you to manage your account in the financial MARKET with a simple
                                    subscription model.<br>
                                    <small>Terms and Conditions apply</small><br>Reach us at {{ $settings->contact_email }}
                                    for more info.
                                </p>
                            </div>
                            <br>
                            <div class="py-3">
                                <a class="btn btn-primary" data-toggle="modal" data-target="#submitmt4modal">
                                    Subscribe Now
                                </a>
                            </div>

                        </div>
                    </div>
                    <hr>
                    <div class="row mt-4">
                        <div class="col-12 py-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h2 class="mb-5">Accounts under management.</h2>
                                @if ($settings->ib_link)
                                    <div>
                                        <a href="{{ $settings->ib_link }}" target="_blank" class="btn btn-primary">
                                            Open trading account
                                        </a>
                                    </div>
                                @endif
                            </div>

                            @if ($subscriptions->count() === 0)
                                <div class="text-center">
                                    <i class="fas fa-database" style="font-size: 50px"></i>
                                    <h4>You have no managed accounts</h4>
                                    <a class="btn btn-primary" data-toggle="modal" data-target="#submitmt4modal">
                                        Add Account
                                    </a>
                                </div>
                            @else
                                <div class=" table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <th>Account</th>
                                            <th>Currency</th>
                                            <th>Leverage</th>
                                            <th>Server</th>
                                            <th>Duration</th>
                                            <th>Account Password</th>
                                            <th>Status</th>
                                            <th>Submited at</th>
                                            <th>Start/End date</th>
                                            <th></th>
                                        </thead>
                                        <tbody>
                                            @foreach ($subscriptions as $sub)
                                                <tr>
                                                    <td>
                                                        {{ $sub->mt4_id }} <br> {{ $sub->account_type }}
                                                    </td>
                                                    <td>
                                                        {{ $sub->currency }}
                                                    </td>
                                                    <td>
                                                        {{ $sub->leverage }}
                                                    </td>
                                                    <td>
                                                        {{ $sub->server }}
                                                    </td>
                                                    <td>
                                                        {{ $sub->duration }}
                                                    </td>
                                                    <td>
                                                        **********
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-info"> {{ $sub->status }}</span>
                                                    </td>
                                                    <td>
                                                        {{ \Carbon\Carbon::parse($sub->created_at)->format('M d Y') }}
                                                    </td>
                                                    <td>
                                                        @if (!empty($sub->start_date))
                                                            {{ \Carbon\Carbon::parse($sub->start_date)->format('M d Y') }}
                                                        @else
                                                            -
                                                        @endif
                                                        /
                                                        @if (!empty($sub->end_date))
                                                            {{ \Carbon\Carbon::parse($sub->end_date)->format('M d Y') }}
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @php
                                                            $endAt = \Carbon\Carbon::parse($sub->end_date);
                                                            $remindAt = \Carbon\Carbon::parse($sub->reminded_at);
                                                        @endphp
                                                        <a href="#" data-bs-toggle="modal"
                                                            class="btn btn-danger btn-sm" onclick="deletemt4()">Cancel</a>
                                                        @if (($sub->status != 'Pending' && now()->isSameDay($remindAt)) || $sub->status == 'Expired')
                                                            <a href="{{ route('renewsub', $sub->id) }}"
                                                                class="btn btn-primary btn-sm">Renew</a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                    {{-- <div class="row">
                        <div class="col-12">
                            <h3 class="">Connect to your trading account to monitor activities on
                                your trading account(s).</h3>
                            <iframe src="{{ $sub_link }}" name="WebTrader" title="{{ $title }}" frameborder="0"
                                style="display: block; border: none; height: 76vh; width: 80vw;"></iframe>
                        </div>
                    </div> --}}
                    <!-- end of chart -->
                </div>
            </div>
        </div>
    </div>
    @include('millage.user.modals')
    <script type="text/javascript">
        function deletemt4() {
            swal({
                title: "Error!",
                text: "Send an Email to {{ $settings->contact_email }} to have your MT4 Details cancelled.",
                icon: "error",
                buttons: {
                    confirm: {
                        text: "Okay",
                        value: true,
                        visible: true,
                        className: "btn btn-danger",
                        closeModal: true
                    }
                }
            });
        }
    </script>
@endsection
