<div>
    <div>
        @include('user.history.nav')
    </div>
    <x-danger-alert />
    <x-success-alert />
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h5>Deposit history</h5>
                    <div class="table-responsive">
                        <table class="table text-center">
                            <thead>
                                <tr>
                                    <th>Amount</th>
                                    <th>Payment mode</th>
                                    <th>Status</th>
                                    <th>Date created</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($deposits as $deposit)
                                    <tr>
                                        <td>{{ $settings->currency }}{{ $deposit->amount }}</td>
                                        <td>{{ $deposit->payment_mode }}</td>
                                        <td>
                                            @if ($deposit->status == 'Processed')
                                                <span class="badge bg-success">{{ $deposit->status }}</span>
                                            @else
                                                <span class="badge bg-danger">{{ $deposit->status }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($deposit->created_at)->toDayDateTimeString() }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="py-5" colspan="4">
                                            <i class="bi bi-database-fill-exclamation" style="font-size: 50px"></i>
                                            <h5>No deposit history</h5>
                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                        <div>
                            {{ $deposits->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
