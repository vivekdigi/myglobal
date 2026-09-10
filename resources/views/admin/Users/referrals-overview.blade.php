@extends('layouts.app')
@section('content')

    <div class="mt-2 mb-3 d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <h4 class="title1 mb-0">Referral Overview</h4>
            <small class="text-muted">All users — who referred them and how many referrals each user has</small>
        </div>
        <span class="badge badge-primary badge-pill px-3 py-2" style="font-size:.85rem;">
            {{ $users->total() }} Total Users
        </span>
    </div>

    <x-admin.alert />

    <div class="row">
        <div class="col-md-12">
            <div class="card">

                {{-- Search --}}
                <div class="card-header py-2">
                    <form method="GET" action="{{ route('admin.referrals.overview') }}" class="d-flex align-items-center" style="gap:8px;">
                        <div class="input-group" style="max-width:340px;">
                            <input type="text"
                                   name="search"
                                   class="form-control form-control-sm"
                                   placeholder="Search by name, email or account ID..."
                                   value="{{ $search }}">
                            <div class="input-group-append">
                                <button class="btn btn-sm btn-primary" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                        @if($search)
                            <a href="{{ route('admin.referrals.overview') }}" class="btn btn-sm btn-secondary">
                                <i class="fa fa-times"></i> Clear
                            </a>
                        @endif
                    </form>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-sm mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="pl-3">#</th>
                                    <th>Account ID</th>
                                    <th>Client Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Referred By</th>
                                    <th class="text-center">Total Referrals</th>
                                    <th>Status</th>
                                    <th>Registered</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $user)
                                    <tr>
                                        <td class="pl-3">{{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}</td>
                                        <td>
                                            <span class="font-weight-bold">{{ $user->accountid ?? 'N/A' }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('viewuser', $user->id) }}" target="_blank">
                                                {{ $user->name }}
                                            </a>
                                        </td>
                                        <td style="font-size:.82rem;" class="text-muted">{{ $user->email }}</td>
                                        <td style="font-size:.82rem;">{{ $user->phone ?? '—' }}</td>
                                        <td>
                                            @if ($user->referrer)
                                                <a href="{{ route('viewuser', $user->referrer->id) }}" target="_blank" class="text-primary">
                                                    {{ $user->referrer->name }}
                                                </a>
                                                <br>
                                                <small class="text-muted">{{ $user->referrer->accountid }}</small>
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($user->referral_count > 0)
                                                <span class="badge badge-success">{{ $user->referral_count }}</span>
                                            @else
                                                <span class="text-muted">0</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($user->status === 'active')
                                                <span class="badge badge-success">Active</span>
                                            @else
                                                <span class="badge badge-danger">{{ ucfirst($user->status) }}</span>
                                            @endif
                                        </td>
                                        <td style="font-size:.82rem;">{{ $user->created_at->format('d M Y') }}</td>
                                        <td>
                                            <a href="{{ route('viewuser', $user->id) }}" class="btn btn-sm btn-outline-primary" style="border-radius:50px; font-size:.72rem; padding:2px 10px;" target="_blank">
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center py-5 text-muted">
                                            @if($search)
                                                <i class="fa fa-search fa-2x mb-2 d-block"></i>
                                                No results found for <strong>"{{ $search }}"</strong>
                                            @else
                                                <i class="fa fa-inbox fa-2x mb-2 d-block"></i>
                                                No users found.
                                            @endif
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                @if ($users->hasPages())
                    <div class="card-footer py-2 d-flex justify-content-between align-items-center flex-wrap">
                        <small class="text-muted">
                            Showing {{ $users->firstItem() }}–{{ $users->lastItem() }} of {{ $users->total() }} users
                        </small>
                        <div>
                            {{ $users->links() }}
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>

    {{-- Per-user referral drill-down section --}}
    @if(request('user_id'))
        @php $drillUser = \App\Models\User::find(request('user_id')); @endphp
        @if($drillUser)
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            Referrals of <strong>{{ $drillUser->name }}</strong>
                            <small class="text-muted">(Account: {{ $drillUser->accountid }})</small>
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-sm mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="pl-3">#</th>
                                        <th>Account ID</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Client Name</th>
                                        <th>Ref. Level</th>
                                        <th>Parent</th>
                                        <th>Status</th>
                                        <th>Date Registered</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {!! $downlines !!}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    @endif

@endsection
