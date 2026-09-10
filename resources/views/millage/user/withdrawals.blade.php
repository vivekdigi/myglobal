@extends('layouts.millage')
@section('title', $title)
@section('content')
    <!-- Page title -->
    <div class="page-title">
        <div class="row justify-content-between align-items-center">
            <div class="mb-3 col-md-6 mb-md-0">
                <h5 class="mb-0 h3 font-weight-400">Place a withdrawal request</h5>
            </div>
        </div>
    </div>
    <x-danger-alert />
    <x-success-alert />
    <div class="row">
        <div class="my-1 col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="my-5 row d-flex nowrap">
                        @foreach ($wmethods as $method)
                            <div class="mb-4 col-lg-4">
                                <div class="card-deck">
                                    <div class="text-center border border-primary rounded-lg card hover-scale-110 popular">
                                        <div class="py-0 border-0 card-header">
                                            <span class="px-4 py-1 mx-auto shadow-sm h6 d-inline-block rounded-bottom">
                                                {{ $method->name }}
                                            </span>

                                            <div class="py-5">
                                                <img src="{{ asset('themes/purposeTheme/assets/img/Wallet.svg.png') }}"
                                                    alt="withdrawal method image" srcset=""
                                                    class="img-fluid img-center" style="height:60px;">
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <ul class="mb-4 list-unstyled">
                                                <li class="d-flex justify-content-between">
                                                    <p>Minimum withdrawable amount: </p>
                                                    <p class="">
                                                        {{ $settings->currency }}{{ number_format($method->minimum) }}</p>
                                                </li>
                                                <li class="d-flex justify-content-between">
                                                    <p>Maximum withdrawable amount</p>
                                                    <p class=" h5">
                                                        {{ $settings->currency }}{{ number_format($method->maximum) }}</p>
                                                </li>
                                                <li class="d-flex justify-content-between">
                                                    <p>
                                                        Charge Type:
                                                    </p>
                                                    <strong>{{ $method->charges_type }}</strong>
                                                </li>
                                                <li class="d-flex justify-content-between">
                                                    <p>
                                                        Charges Amount:
                                                    </p>

                                                    <strong>
                                                        @if ($method->charges_type == 'percentage')
                                                            {{ $method->charges_amount }}%
                                                        @else
                                                            {{ $settings->currency }}{{ $method->charges_amount }}
                                                        @endif
                                                    </strong>
                                                </li>
                                                <li class="d-flex justify-content-between">
                                                    <p>
                                                        Duration:
                                                    </p>
                                                    <strong>{{ $method->duration }}</strong>
                                                </li>
                                            </ul>
                                            @if ($settings->enable_with == 'false')
                                                <button class="mb-3 btn btn-sm btn-primary" data-toggle="modal"
                                                    data-target="#withdrawdisabled"><i class="fa fa-plus"></i> Request
                                                    withdrawal</button>
                                            @else
                                                <form action='{{ route('withdrawamount') }}' method="POST">
                                                    @csrf
                                                    <div class="form-group">
                                                        <input type="hidden" value="{{ $method->name }}" name="method">
                                                        <button class="mb-3 btn btn-sm btn-primary" type='submit'><i
                                                                class="fa fa-plus"></i> Request withdrawal</button>
                                                    </div>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!-- Withdrawal Modal -->
                    <div id="withdrawdisabled" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header ">
                                    <h6 class="modal-title">Withdrawal Status</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                </div>
                                <div class="modal-body ">
                                    <h6 class="">Withdrawal is Disabled at the moment, Please check
                                        back later</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Withdrawals Modal -->
                </div>
            </div>
        </div>
    </div>
@endsection
