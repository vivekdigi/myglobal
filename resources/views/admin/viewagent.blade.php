@extends('layouts.app')
@section('content')
    <div class="mt-2 mb-4">
        <h1 class="title1 ">View agent ({{ $agent->name }}) clients</h1>
    </div>
    <x-admin.alert />
    <div class="mb-5 row">
        <div class="col card p-4  shadow">
            <div class="table-responsive" data-example-id="hoverable-table">
                <table class="table table-hover ">
                    <thead>
                        <tr>
                            <th>Client name</th>
                            <th>Client Inv. plan</th>
                            <th>Client status</th>
                            <th>Earnings</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ag_r as $client)
                            <tr>
                                <td>{{ $client->name }}</td>
                                @if (isset($client->dplan->name))
                                    <td>{{ $client->dplan->name }}</td>
                                @else
                                    <td>NULL</td>
                                @endif
                                <td>{{ $client->status }}</td>
                                <td>{{ $client->account_bal }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
