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
                    <h5>Withdrawal history</h5>
                    <div class="table-responsive">
                        <table class="table text-center">
                            <thead>
                                <tr>
                                    <th>Amount requested</th>
                                    <th>Amount + charges</th>
                                    <th>Recieving mode</th>
                                    <th>Status</th>
                                    <th>Date created</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($withdrawals as $with)
                                    <tr>
                                        <td>{{ $settings->currency }}{{ $with->amount }}</td>
                                        <td>{{ $settings->currency }}{{ $with->to_deduct }}</td>
                                        <td>{{ $with->payment_mode }}</td>
                                        <td>
                                            @if ($with->status == 'Processed')
                                                <span class="badge bg-success">{{ $with->status }}</span>
                                            @else
                                                <span class="badge bg-danger">{{ $with->status }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($with->created_at)->toDayDateTimeString() }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="py-5" colspan="5">
                                            <i class="bi bi-database-fill-exclamation" style="font-size: 50px"></i>
                                            <h5>No withdrawal history</h5>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div>
                            {{ $withdrawals->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
