@extends('layouts.app')
@section('content')

    <div class="mt-2 mb-3 d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <h4 class="title1 mb-0">Second Account Requests</h4>
            <small class="text-muted">Users who have requested a second trading account</small>
        </div>
        <span class="badge badge-primary badge-pill px-3 py-2" style="font-size:.85rem;">
            {{ $requests->total() }} Total
        </span>
    </div>

    <x-admin.alert />

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header py-2">
                    <form method="GET" action="{{ route('admin.second.requests') }}" class="d-flex align-items-center" style="gap:8px;">
                        <div class="input-group" style="max-width:320px;">
                            <input type="text"
                                   name="search"
                                   class="form-control form-control-sm"
                                   placeholder="Search by name or email..."
                                   value="{{ $search }}">
                            <div class="input-group-append">
                                <button class="btn btn-sm btn-primary" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                        @if($search)
                            <a href="{{ route('admin.second.requests') }}" class="btn btn-sm btn-secondary">
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
                                    <th>User</th>
                                    <th>Email</th>
                                    <th>Account ID</th>
                                    <th>Requested At</th>
                                    <th>Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($requests as $req)
                                    <tr>
                                        <td class="pl-3">{{ ($requests->currentPage() - 1) * $requests->perPage() + $loop->iteration }}</td>
                                        <td>
                                            <a href="{{ route('viewuser', $req->user_id) }}" target="_blank" class="font-weight-bold">
                                                {{ $req->user_name }}
                                            </a>
                                        </td>
                                        <td class="text-muted" style="font-size:.85rem;">{{ $req->user_email }}</td>
                                        <td>{{ $req->user->accountid ?? 'N/A' }}</td>
                                        <td style="font-size:.82rem;">{{ $req->created_at->format('d M Y, h:i A') }}</td>
                                        <td>
                                            @if ($req->status === 'approved')
                                                <span class="badge badge-success">Approved</span>
                                            @elseif ($req->status === 'rejected')
                                                <span class="badge badge-danger">Rejected</span>
                                            @else
                                                <span class="badge badge-warning">Pending</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-link text-dark p-0"
                                                    type="button"
                                                    id="dropdownMenu{{ $req->id }}"
                                                    data-toggle="dropdown"
                                                    aria-haspopup="true"
                                                    aria-expanded="false"
                                                    style="font-size:1.2rem;">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu{{ $req->id }}">
                                                    @if ($req->status !== 'approved')
                                                        <form action="{{ route('admin.second.status', $req->id) }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="status" value="approved">
                                                            <button type="submit" class="dropdown-item text-success">
                                                                <i class="fa fa-check mr-2"></i> Approve
                                                            </button>
                                                        </form>
                                                    @endif
                                                    @if ($req->status !== 'rejected')
                                                        <form action="{{ route('admin.second.status', $req->id) }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="status" value="rejected">
                                                            <button type="submit" class="dropdown-item text-danger">
                                                                <i class="fa fa-times mr-2"></i> Reject
                                                            </button>
                                                        </form>
                                                    @endif
                                                    @if ($req->status === 'approved')
                                                        <span class="dropdown-item text-muted disabled">
                                                            <i class="fa fa-check-circle mr-2"></i> Already Approved
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5 text-muted">
                                            @if($search)
                                                <i class="fa fa-search fa-2x mb-2 d-block"></i>
                                                No results found for <strong>"{{ $search }}"</strong>
                                            @else
                                                <i class="fa fa-inbox fa-2x mb-2 d-block"></i>
                                                No second account requests yet.
                                            @endif
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                @if ($requests->hasPages())
                    <div class="card-footer py-2 d-flex justify-content-between align-items-center flex-wrap">
                        <small class="text-muted">
                            Showing {{ $requests->firstItem() }}–{{ $requests->lastItem() }} of {{ $requests->total() }} results
                        </small>
                        <div>
                            {{ $requests->links() }}
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>

@endsection
