<div>
    <div>
        @include('user.history.nav')
    </div>
    <x-danger-alert />
    <x-success-alert />
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5>Other transactions history</h5>
                    <div class="table-responsive">
                        <table class="table text-center">
                            <thead>
                                <tr>
                                    <th>Amount</th>
                                    <th>Type</th>
                                    <th>Description</th>
                                    <th>Date created</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($others as $history)
                                    <tr>
                                        <td>{{ $settings->currency }}{{ $history->amount }}</td>
                                        <td>{{ $history->type }}</td>
                                        <td>{{ $history->plan }}</td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($history->created_at)->toDayDateTimeString() }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="py-5" colspan="5">
                                            <i class="bi bi-database-fill-exclamation" style="font-size: 50px"></i>
                                            <h5>No transaction history</h5>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div>
                        {{ $others->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
