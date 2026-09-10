@extends('layouts.app')
@section('content')

    <div class="mt-2 mb-3 d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <h4 class="title1 mb-0">Third Accounts</h4>
            <small class="text-muted">All created third trading accounts with credentials</small>
        </div>
        <div class="d-flex" style="gap:8px;">
            <span class="badge badge-primary badge-pill px-3 py-2" style="font-size:.85rem;">
                {{ $accounts->total() }} Total
            </span>
            <a href="{{ route('admin.third.trashed') }}" class="btn btn-sm btn-outline-danger" style="border-radius:50px;">
                <i class="fa fa-trash mr-1"></i> Trashed
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
                        <form method="GET" action="{{ route('admin.third.list') }}" class="d-flex align-items-center" style="gap:8px;">
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
                                <a href="{{ route('admin.third.list') }}" class="btn btn-sm btn-secondary">
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
                                    <i class="fa fa-trash mr-1"></i> Move to Trash
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
                                    <th>Third Account ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Primary Account</th>
                                    <th>Login Password</th>
                                    <th>Investor Password</th>
                                    <th>Master Password</th>
                                    <th>Balance</th>
                                    <th>Created</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($accounts as $acc)
                                    <tr>
                                        <td class="pl-3">
                                            <input type="checkbox" class="row-check" value="{{ $acc->id }}">
                                        </td>
                                        <td>{{ ($accounts->currentPage() - 1) * $accounts->perPage() + $loop->iteration }}</td>
                                        <td>
                                            <span class="badge badge-info" style="font-size:.85rem;">
                                                {{ $acc->accountid }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('viewuser', $acc->id) }}" target="_blank" class="font-weight-bold">
                                                {{ $acc->name }}
                                            </a>
                                        </td>
                                        <td style="font-size:.82rem;" class="text-muted">{{ $acc->email }}</td>
                                        <td>
                                            @if($acc->parentUser)
                                                <a href="{{ route('viewuser', $acc->parentUser->id) }}" target="_blank">
                                                    {{ $acc->parentUser->name }}
                                                </a>
                                                <br>
                                                <small class="text-muted">{{ $acc->parentUser->accountid }}</small>
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($acc->login_password_plain)
                                                <div class="d-flex align-items-center" style="gap:4px;">
                                                    <span class="pwd-dots-{{ $acc->id }}" style="font-family:monospace; font-size:.82rem;">••••••••</span>
                                                    <span class="pwd-plain-{{ $acc->id }}" style="display:none; font-family:monospace; font-size:.82rem; letter-spacing:1px;">{{ $acc->login_password_plain }}</span>
                                                    <button type="button" class="btn btn-sm btn-link p-0 toggle-pwd-btn" data-id="{{ $acc->id }}" title="Show/Hide">
                                                        <i class="fa fa-eye text-muted" id="eye-{{ $acc->id }}"></i>
                                                    </button>
                                                </div>
                                            @else
                                                <span class="text-danger small"><i class="fa fa-exclamation-circle mr-1"></i>Not set</span>
                                            @endif
                                            <button type="button"
                                                class="btn btn-link p-0 mt-1 d-block"
                                                style="font-size:.72rem; color:#007bff;"
                                                data-toggle="modal"
                                                data-target="#changePwdModal{{ $acc->id }}">
                                                <i class="fa fa-key mr-1"></i>
                                                {{ $acc->login_password_plain ? 'Change' : 'Set Password' }}
                                            </button>

                                            {{-- Change Password Modal --}}
                                            <div class="modal fade" id="changePwdModal{{ $acc->id }}" tabindex="-1" role="dialog">
                                                <div class="modal-dialog modal-sm" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header py-2">
                                                            <h6 class="modal-title">
                                                                {{ $acc->login_password_plain ? 'Change' : 'Set' }} Password
                                                                — <strong>{{ $acc->accountid }}</strong>
                                                            </h6>
                                                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                        </div>
                                                        <form action="{{ route('admin.third.updatepwd', $acc->id) }}" method="POST">
                                                            @csrf
                                                            <div class="modal-body">
                                                                <div class="form-group mb-2">
                                                                    <label class="small font-weight-bold">New Password</label>
                                                                    <div class="input-group input-group-sm">
                                                                        <input type="text"
                                                                               name="login_password"
                                                                               id="newPwd{{ $acc->id }}"
                                                                               class="form-control"
                                                                               placeholder="Enter or generate"
                                                                               required>
                                                                        <div class="input-group-append">
                                                                            <button type="button"
                                                                                class="btn btn-outline-secondary gen-pwd-btn"
                                                                                data-target="newPwd{{ $acc->id }}"
                                                                                title="Generate">
                                                                                <i class="fa fa-sync-alt"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer py-2">
                                                                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancel</button>
                                                                <button type="submit" class="btn btn-sm btn-primary">Save</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if($acc->account_credentials)
                                                <span class="badge badge-secondary" style="font-size:.8rem; letter-spacing:1px;">
                                                    {{ $acc->account_credentials->investor_password }}
                                                </span>
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($acc->account_credentials)
                                                <span class="badge badge-dark" style="font-size:.8rem; letter-spacing:1px;">
                                                    {{ $acc->account_credentials->master_password }}
                                                </span>
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                        <td>
                                            <strong>{{ $settings->currency }}{{ number_format($acc->account_bal, 2) }}</strong>
                                        </td>
                                        <td style="font-size:.82rem;">{{ $acc->created_at->format('d M Y') }}</td>
                                        <td class="text-center">
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-link text-dark p-0"
                                                    type="button"
                                                    id="secDropdown{{ $acc->id }}"
                                                    data-toggle="dropdown"
                                                    aria-haspopup="true"
                                                    aria-expanded="false"
                                                    style="font-size:1.2rem;">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="secDropdown{{ $acc->id }}">
                                                    <a href="{{ route('viewuser', $acc->id) }}" class="dropdown-item" target="_blank">
                                                        <i class="fa fa-eye mr-2 text-primary"></i> View
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    <form action="{{ route('admin.third.destroy', $acc->id) }}" method="POST"
                                                          onsubmit="return confirm('Move third account {{ $acc->accountid }} to trash?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger">
                                                            <i class="fa fa-trash mr-2"></i> Move to Trash
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="12" class="text-center py-5 text-muted">
                                            @if($search)
                                                <i class="fa fa-search fa-2x mb-2 d-block"></i>
                                                No results for <strong>"{{ $search }}"</strong>
                                            @else
                                                <i class="fa fa-inbox fa-2x mb-2 d-block"></i>
                                                No third accounts created yet.
                                                <br>
                                                <a href="{{ route('admin.third.create') }}" class="btn btn-sm btn-primary mt-2">
                                                    Create First Third Account
                                                </a>
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
                            Showing {{ $accounts->firstItem() }}–{{ $accounts->lastItem() }} of {{ $accounts->total() }} accounts
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
    // Eye toggle
    document.querySelectorAll('.toggle-pwd-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var id    = this.dataset.id;
            var dots  = document.querySelector('.pwd-dots-' + id);
            var plain = document.querySelector('.pwd-plain-' + id);
            var eye   = document.getElementById('eye-' + id);

            if (plain.style.display === 'none') {
                plain.style.display = 'inline';
                dots.style.display  = 'none';
                eye.classList.remove('fa-eye');
                eye.classList.add('fa-eye-slash');
            } else {
                plain.style.display = 'none';
                dots.style.display  = 'inline';
                eye.classList.remove('fa-eye-slash');
                eye.classList.add('fa-eye');
            }
        });
    });

    // Password generator inside modal
    document.querySelectorAll('.gen-pwd-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var targetId = this.dataset.target;
            var chars = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz23456789@#!';
            var pwd = '';
            for (var i = 0; i < 10; i++) {
                pwd += chars.charAt(Math.floor(Math.random() * chars.length));
            }
            document.getElementById(targetId).value = pwd;
        });
    });

    // Bulk delete
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

    if (selectAll) {
        selectAll.addEventListener('change', function () {
            document.querySelectorAll('.row-check').forEach(function (cb) {
                cb.checked = selectAll.checked;
            });
            syncBar();
        });
    }

    document.querySelectorAll('.row-check').forEach(function (cb) {
        cb.addEventListener('change', function () {
            var all = document.querySelectorAll('.row-check');
            var chk = getChecked();
            if (selectAll) {
                selectAll.indeterminate = chk.length > 0 && chk.length < all.length;
                selectAll.checked       = chk.length === all.length;
            }
            syncBar();
        });
    });

    window.confirmBulk = function (form) {
        var checked = getChecked();
        if (checked.length === 0) return false;
        if (!confirm('Move ' + checked.length + ' selected account(s) to trash?')) return false;

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
