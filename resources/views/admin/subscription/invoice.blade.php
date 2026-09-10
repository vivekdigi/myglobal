@extends('layouts.app')
@section('content')
    <div class="mt-2 mb-4">
        <h1 class="title1">Invoices for account: {{ $account->account_name }}</h1>
    </div>
    <x-admin.alert />
    <div class="mt-2 mb-5 row">
        <div class="col-12">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Invoice ID</th>
                                <th scope="col">MT4 Account ID</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Status</th>
                                <th scope="col">Date Created</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($invoices as $invoice)
                                <tr>
                                    <th scope="row">#{{ $invoice->invoice_id }}</th>
                                    <td>{{ $invoice->account->mt4_id }}</td>
                                    <td> {{ $settings->currency }}{{ number_format($invoice->amount) }}</td>
                                    <td>
                                        @if ($invoice->status == 'paid')
                                            <span class="badge badge-success">{{ $invoice->status }}</span>
                                        @endif
                                        @if ($invoice->status == 'Unpaid')
                                            <span class="badge badge-danger">{{ $invoice->status }}</span>
                                        @endif
                                        @if ($invoice->status == 'Created')
                                            <span class="badge badge-warning">{{ $invoice->status }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $invoice->created_at->format('M d Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="6">
                                        No Data Available
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div>
                    {{ $invoices->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
