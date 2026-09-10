@extends('layouts.app')
@section('content')
    <div class="mt-2 mb-4">
        <h1 class="title1">Trading Accounts</h1>
        <p class="">
            Manage trading accounts submitted by users. Collect their submitted details and connect to your
            master trading account
        </p>
    </div>
    <x-admin.alert />
    @if ($settings->subscription_type == 'Percentage')
        <div class="alert alert-info fade show" role="alert">
            <span class=" font-weight-bolder">NOTE:</span>
            You are using percentage share subsciption model
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="mt-2 mb-5 row">
        <div class="col-12">
            <div class="card p-3">
                @if ($settings->use_copytrade)
                    <div class="row">
                        <div class="col-12">
                            <ul class="nav nav-pills">
                                <li class="nav-item">
                                    <a href="{{ route('msubtrade') }}" class="nav-link active">Submited Accounts</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('tacnts') }}" class="nav-link">Connected Accounts</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                @endif
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive" data-example-id="hoverable-table">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>User</th>
                                        <th>Account</th>
                                        <th>Account Password</th>
                                        <th>Account Type</th>
                                        <th>MT Type</th>
                                        <th>Account Name</th>
                                        <th>Currency</th>
                                        <th>Leverage</th>
                                        <th>Server</th>
                                        <th>Provider</th>
                                        <th>Duration</th>
                                        <th>Submitted at</th>
                                        <th>Started at</th>
                                        <th>Expiring at</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($subscriptions as $sub)
                                        <tr>
                                            <td>{{ $sub->tuser->name }} {{ $sub->tuser->l_name }}</td>
                                            <td>{{ $sub->mt4_id }}</td>
                                            <td>{{ $sub->mt4_password }}</td>
                                            <td>{{ $sub->account_type }}</td>
                                            <td>{{ $sub->mt_type }}</td>
                                            <td>{{ $sub->account_name }}</td>
                                            <td>{{ $sub->currency }}</td>
                                            <td>{{ $sub->leverage }}</td>
                                            <td>{{ $sub->server }}</td>
                                            <td>{{ $sub->provider ? $sub->provider : '-' }}</td>
                                            <td>{{ $sub->duration ? $sub->duration : '-' }}</td>
                                            <td>{{ $sub->created_at->toDayDateTimeString() }}
                                            </td>
                                            <td>
                                                @if (!empty($sub->start_date))
                                                    {{ $sub->start_date->toDayDateTimeString() }}
                                                @else
                                                    Not Started yet
                                                @endif
                                            </td>
                                            <td>
                                                @if (!empty($sub->end_date))
                                                    {{ $sub->end_date->toDayDateTimeString() }}
                                                @else
                                                    Not Started yet
                                                @endif

                                            </td>
                                            <td><span @class([
                                                'badge',
                                                'badge-success' => $sub->status === 'Active',
                                                'badge-danger' => $sub->status !== 'Active',
                                            ])>{{ $sub->status }}</span></td>
                                            <td>
                                                @if ($sub->status == 'Pending')
                                                    <form action="{{ route('create.sub') }}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="login" value="{{ $sub->mt4_id }}">
                                                        <input type="hidden" name="password"
                                                            value="{{ $sub->mt4_password }}">
                                                        <input type="hidden" name="serverName"
                                                            value="{{ $sub->server }}">
                                                        <input type="hidden" name="acntype"
                                                            value="{{ $sub->account_type }}">
                                                        <input type="hidden" name="leverage" value="{{ $sub->leverage }}">
                                                        <input type="hidden" name="currency" value="{{ $sub->currency }}">
                                                        <input type="hidden" name="name"
                                                            value="{{ $sub->account_name }}">
                                                        <input type="hidden" name="mt4id" value="{{ $sub->id }}">
                                                        <button type="submit" class="m-1 btn btn-info btn-sm">
                                                            Process
                                                        </button>
                                                    </form>
                                                @endif
                                                <a href="{{ url('admin/dashboard/delsub') }}/{{ $sub->id }}"
                                                    class="btn btn-danger btn-sm m-1">Delete</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $subscriptions->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
