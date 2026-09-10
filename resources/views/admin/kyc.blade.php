@extends('layouts.app')
@section('content')
    <div class="mt-2 mb-4">
        <h1 class="title1">{{ $settings->site_name }} KYC Application list</h1>
    </div>
    <x-admin.alert />
    <div class="mb-5 row">
        <div class="col-12 card p-4  shadow">
            <div class="bs-example widget-shadow table-responsive" data-example-id="hoverable-table">
                <table id="ShipTable" class="table table-hover">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>User Email</th>
                            <th>User Account id</th>
                            <th>KYC Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kycs as $list)
                            <tr>
                                <td>
                                    @if ($list->user)
                                        {{ $list->user->name }}
                                    @endif
                                </td>
                                <td>
                                    @if ($list->user)
                                        {{ $list->user->email }}
                                    @endif
                                </td>
                                <td>
                                    @if ($list->user)
                                        {{ $list->user->accountid }}
                                    @endif
                                </td>
                                <td>
                                    @if ($list->status == 'Verified')
                                        <span class="badge badge-success">Verified</span>
                                    @else
                                        <span class="badge badge-danger">{{ $list->status }}</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('viewkyc', $list->id) }}" class="btn btn-primary btn-sm">View
                                        application</a>

                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
