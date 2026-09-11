@extends('layouts.app')
@section('content')

    <div class="mt-2 mb-3 d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <h4 class="title1 mb-0">Third Account Requests</h4>
            <small class="text-muted">Users who have requested a third trading account</small>
        </div>
        <div class="d-flex align-items-center" style="gap:8px;">
            <span class="badge badge-primary badge-pill px-3 py-2" style="font-size:.85rem;">
                {{ $requests->total() }} Total
            </span>
            <a href="{{ route('admin.third.create') }}" class="btn btn-sm btn-success" style="border-radius:50px;">
                <i class="fa fa-plus mr-1"></i> Create 3rd Account
            </a>
            <a href="{{ route('admin.third.list') }}" class="btn btn-sm btn-outline-primary" style="border-radius:50px;">
                <i class="fa fa-list mr-1"></i> All 3rd Accounts
            </a>
        </div>
    </div>

    <x-admin.alert />

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header py-2">
                    <div class="d-flex align-items-center flex-wrap" style="gap:8px;">
                        {{-- Search --}}
                        <form method="GET" action="{{ route('admin.third.requests') }}" class="d-flex align-items-center" style="gap:8px;">
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
                                <a href="{{ route('admin.third.requests') }}" class="btn btn-sm btn-secondary">
                                    <i class="fa fa-times"></i> Clear
                                </a>
                            @endif
                        </form>

                        {{-- Bulk action bar --}}
                        <div id="bulkBar" class="d-none align-items-center" style="gap:8px;">
                            <span id="bulkCount" class="text-muted small font-weight-bold"></span>
                            <form id="bulkDeleteForm" action="{{ route('admin.third.bulk-destroy') }}" method="POST"
                                  onsubmit="return confirmBulk(this)">
                                @csrf
                                @method('DELETE')
                                <div id="bulkIdsContainer"></div>
                                <button type="submit" class="btn btn-sm btn-danger" style="border-radius:50px;">
                                    <i class="fa fa-trash mr-1"></i> Delete Selected
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive" style="min-height: 280px;">
                        <table class="table table-hover table-sm mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="pl-3" style="width:36px;">
                                        <input type="checkbox" id="selectAll" title="Select all">
                                    </th>
                                    <th>#</th>
                                    <th>User</th>
                                    <th>Email</th>
                                    <th>Account ID</th>
                                    <th>Requested At</th>
                                    <th>Status</th>
                                    <th class="text-center">3rd Accounts</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($requests as $req)
                                    <tr>
                                        <td class="pl-3">
                                            <input type="checkbox" class="row-check" value="{{ $req->id }}">
                                        </td>
                                        <td>{{ ($requests->currentPage() - 1) * $requests->perPage() + $loop->iteration }}</td>
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
                                            @php $tCount = $thirdCountMap[$req->user_id] ?? 0; @endphp
                                            @if ($tCount > 0)
                                                <a href="{{ route('admin.third.list', ['search' => $req->user_name]) }}"
                                                   class="badge badge-success px-2 py-1"
                                                   style="font-size:.8rem; border-radius:50px; text-decoration:none;"
                                                   title="View 3rd accounts for {{ $req->user_name }}">
                                                    <i class="fa fa-user-circle mr-1"></i>{{ $tCount }}
                                                </a>
                                            @else
                                                <span class="text-muted" style="font-size:.82rem;">—</span>
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
                                                        <form action="{{ route('admin.third.status', $req->id) }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="status" value="approved">
                                                            <button type="submit" class="dropdown-item text-success">
                                                                <i class="fa fa-check mr-2"></i> Approve
                                                            </button>
                                                        </form>
                                                    @endif
                                                    @if ($req->status !== 'rejected')
                                                        <form action="{{ route('admin.third.status', $req->id) }}" method="POST">
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
                                                    <div class="dropdown-divider"></div>
                                                    @if(in_array($req->user_id, $createdUserIds))
                                                        <span class="dropdown-item text-success disabled">
                                                            <i class="fa fa-check-double mr-2"></i> Account Already Created
                                                        </span>
                                                    @else
                                                        <a href="{{ route('admin.third.create', ['user_id' => $req->user_id]) }}" class="dropdown-item text-primary">
                                                            <i class="fa fa-user-plus mr-2"></i> Create 3rd Account
                                                        </a>
                                                    @endif
                                                    <div class="dropdown-divider"></div>
                                                    <form action="{{ route('admin.third.destroy', $req->id) }}" method="POST"
                                                          onsubmit="return confirm('Delete this third account request? This cannot be undone.')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger">
                                                            <i class="fa fa-trash mr-2"></i> Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-5 text-muted">
                                            @if($search)
                                                <i class="fa fa-search fa-2x mb-2 d-block"></i>
                                                No results found for <strong>"{{ $search }}"</strong>
                                            @else
                                                <i class="fa fa-inbox fa-2x mb-2 d-block"></i>
                                                No third account requests yet.
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

@push('scripts')
<script>
(function () {
    var selectAll = document.getElementById('selectAll');
    var bulkBar   = document.getElementById('bulkBar');
    var bulkCount = document.getElementById('bulkCount');
    var bulkIds   = document.getElementById('bulkIdsContainer');

    function getChecked() {
        return Array.from(document.querySelectorAll('.row-check:checked'));
    }

    function syncBar() {
        var checked = getChecked();
        if (checked.length > 0) {
            bulkBar.classList.remove('d-none');
            bulkBar.classList.add('d-flex');
            bulkCount.textContent = checked.length + ' selected';
        } else {
            bulkBar.classList.add('d-none');
            bulkBar.classList.remove('d-flex');
        }
    }

    selectAll.addEventListener('change', function () {
        document.querySelectorAll('.row-check').forEach(function (cb) {
            cb.checked = selectAll.checked;
        });
        syncBar();
    });

    document.querySelectorAll('.row-check').forEach(function (cb) {
        cb.addEventListener('change', function () {
            var all = document.querySelectorAll('.row-check');
            var chk = getChecked();
            selectAll.indeterminate = chk.length > 0 && chk.length < all.length;
            selectAll.checked       = chk.length === all.length;
            syncBar();
        });
    });

    window.confirmBulk = function (form) {
        var checked = getChecked();
        if (checked.length === 0) return false;
        if (!confirm('Delete ' + checked.length + ' selected request(s)? This cannot be undone.')) return false;

        bulkIds.innerHTML = '';
        checked.forEach(function (cb) {
            var inp = document.createElement('input');
            inp.type  = 'hidden';
            inp.name  = 'ids[]';
            inp.value = cb.value;
            bulkIds.appendChild(inp);
        });
        return true;
    };
})();
</script>
@endpush
