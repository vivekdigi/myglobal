@extends('layouts.app')
@section('content')

    <div class="mt-2 mb-3 d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <h4 class="title1 mb-0">
                <i class="fa fa-trash text-danger mr-2"></i>Trashed Secondary Accounts
            </h4>
            <small class="text-muted">Soft-deleted accounts — restore or permanently delete them here</small>
        </div>
        <div class="d-flex align-items-center" style="gap:8px;">
            <span class="badge badge-danger badge-pill px-3 py-2" style="font-size:.85rem;">
                {{ $accounts->total() }} Trashed
            </span>
            <a href="{{ route('admin.secondary.list') }}" class="btn btn-sm btn-outline-primary" style="border-radius:50px;">
                <i class="fa fa-arrow-left mr-1"></i> Back to Active
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
                        <form method="GET" action="{{ route('admin.secondary.trashed') }}" class="d-flex align-items-center" style="gap:8px;">
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
                                <a href="{{ route('admin.secondary.trashed') }}" class="btn btn-sm btn-secondary">
                                    <i class="fa fa-times"></i> Clear
                                </a>
                            @endif
                        </form>

                        {{-- Bulk action bar --}}
                        <div id="bulkBar" class="d-none align-items-center" style="gap:8px;">
                            <span id="bulkCount" class="text-muted small font-weight-bold"></span>

                            {{-- Bulk Restore --}}
                            <form id="bulkRestoreForm" action="{{ route('admin.secondary.bulk-restore') }}" method="POST"
                                  onsubmit="return confirmBulkAction(this, 'restore')">
                                @csrf
                                <div id="bulkRestoreIds"></div>
                                <button type="submit" class="btn btn-sm btn-success" style="border-radius:50px;">
                                    <i class="fa fa-undo mr-1"></i> Restore Selected
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-sm mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="pl-3" style="width:36px;">
                                        <input type="checkbox" id="selectAll" title="Select all">
                                    </th>
                                    <th>#</th>
                                    <th>Secondary Account ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Primary Account</th>
                                    <th>Deleted At</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($accounts as $acc)
                                    <tr class="table-danger" style="opacity:.85;">
                                        <td class="pl-3">
                                            <input type="checkbox" class="row-check" value="{{ $acc->id }}">
                                        </td>
                                        <td>{{ ($accounts->currentPage() - 1) * $accounts->perPage() + $loop->iteration }}</td>
                                        <td>
                                            <span class="badge badge-secondary" style="font-size:.85rem;">
                                                {{ $acc->accountid }}
                                            </span>
                                        </td>
                                        <td class="font-weight-bold text-muted">{{ $acc->name }}</td>
                                        <td style="font-size:.82rem;" class="text-muted">{{ $acc->email }}</td>
                                        <td>
                                            @if($acc->parentUser)
                                                {{ $acc->parentUser->name }}
                                                <br>
                                                <small class="text-muted">{{ $acc->parentUser->accountid }}</small>
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                        <td style="font-size:.82rem;" class="text-danger">
                                            <i class="fa fa-clock mr-1"></i>
                                            {{ $acc->deleted_at->format('d M Y, h:i A') }}
                                        </td>
                                        <td class="text-center">
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-link text-dark p-0"
                                                    type="button"
                                                    id="trashDrop{{ $acc->id }}"
                                                    data-toggle="dropdown"
                                                    aria-haspopup="true"
                                                    aria-expanded="false"
                                                    style="font-size:1.2rem;">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="trashDrop{{ $acc->id }}">
                                                    {{-- Restore --}}
                                                    <form action="{{ route('admin.secondary.restore', $acc->id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="dropdown-item text-success">
                                                            <i class="fa fa-undo mr-2"></i> Restore
                                                        </button>
                                                    </form>
                                                    <div class="dropdown-divider"></div>
                                                    {{-- Permanent delete --}}
                                                    <form action="{{ route('admin.secondary.force-destroy', $acc->id) }}" method="POST"
                                                          onsubmit="return confirm('Permanently delete account {{ $acc->accountid }}? This CANNOT be undone.')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger">
                                                            <i class="fa fa-times-circle mr-2"></i> Delete Permanently
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-5 text-muted">
                                            @if($search)
                                                <i class="fa fa-search fa-2x mb-2 d-block"></i>
                                                No trashed results for <strong>"{{ $search }}"</strong>
                                            @else
                                                <i class="fa fa-check-circle fa-2x mb-2 d-block text-success"></i>
                                                Trash is empty — no deleted secondary accounts.
                                            @endif
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                @if ($accounts->hasPages())
                    <div class="card-footer py-2 d-flex justify-content-between align-items-center flex-wrap">
                        <small class="text-muted">
                            Showing {{ $accounts->firstItem() }}–{{ $accounts->lastItem() }} of {{ $accounts->total() }} trashed
                        </small>
                        <div>{{ $accounts->links() }}</div>
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

    window.confirmBulkAction = function (form, action) {
        var checked = getChecked();
        if (checked.length === 0) return false;

        var msg = action === 'restore'
            ? 'Restore ' + checked.length + ' account(s)?'
            : 'Permanently delete ' + checked.length + ' account(s)? This cannot be undone.';

        if (!confirm(msg)) return false;

        // Inject IDs into the correct form
        var container = form.querySelector('[id^="bulk"]');
        if (!container) {
            container = document.createElement('div');
            form.appendChild(container);
        }
        container.innerHTML = '';
        checked.forEach(function (cb) {
            var inp = document.createElement('input');
            inp.type  = 'hidden';
            inp.name  = 'ids[]';
            inp.value = cb.value;
            container.appendChild(inp);
        });
        return true;
    };
})();
</script>
@endpush
