@extends('layouts.app')
@section('content')

    <div class="mt-2 mb-3 d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <h4 class="title1 mb-0">Accounts</h4>
            <small class="text-muted">Manage trading account credentials (account_id, investor &amp; master passwords)</small>
        </div>
        <span class="badge badge-primary badge-pill px-3 py-2" style="font-size:.85rem;">
            {{ $accounts->total() }} Total
        </span>
    </div>

    <x-admin.alert />

    {{-- ── Import Card ──────────────────────────────────────────────────────── --}}
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header py-2 d-flex align-items-center justify-content-between">
                    <span class="font-weight-bold"><i class="fa fa-upload mr-2 text-primary"></i>Import Accounts (CSV / Excel)</span>
                    <a href="{{ route('admin.accounts.sample') }}" class="btn btn-sm btn-outline-secondary" style="border-radius:50px;">
                        <i class="fa fa-download mr-1"></i> Download Sample CSV
                    </a>
                </div>
                <div class="card-body py-3">
                    <form action="{{ route('admin.accounts.import') }}" method="POST" enctype="multipart/form-data"
                          class="d-flex align-items-center flex-wrap" style="gap:10px;">
                        @csrf
                        <div>
                            <input type="file" name="file" id="importFile"
                                   class="form-control form-control-sm"
                                   accept=".csv,.xlsx,.xls,.txt"
                                   style="max-width:320px;"
                                   required>
                            <small class="text-muted d-block mt-1">
                                Accepted: <strong>.csv</strong>, <strong>.xlsx</strong>, <strong>.xls</strong> &nbsp;|&nbsp;
                                Required columns: <code>account_id</code>, <code>investor_password</code>, <code>master_password</code>
                                &nbsp;|&nbsp; Existing <code>account_id</code> rows will be <strong>updated</strong>.
                            </small>
                        </div>
                        <button type="submit" class="btn btn-sm btn-primary" style="border-radius:50px;">
                            <i class="fa fa-upload mr-1"></i> Import
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Accounts Table ───────────────────────────────────────────────────── --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header py-2">
                    <form method="GET" action="{{ route('admin.accounts.index') }}" class="d-flex align-items-center" style="gap:8px;">
                        <div class="input-group" style="max-width:300px;">
                            <input type="text"
                                   name="search"
                                   class="form-control form-control-sm"
                                   placeholder="Search by account ID..."
                                   value="{{ $search }}">
                            <div class="input-group-append">
                                <button class="btn btn-sm btn-primary" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                        @if($search)
                            <a href="{{ route('admin.accounts.index') }}" class="btn btn-sm btn-secondary">
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
                                    <th>Investor Password</th>
                                    <th>Master Password</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($accounts as $acc)
                                    <tr>
                                        <td class="pl-3">{{ ($accounts->currentPage() - 1) * $accounts->perPage() + $loop->iteration }}</td>
                                        <td>
                                            <span class="badge badge-info" style="font-size:.85rem;">{{ $acc->account_id }}</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-secondary" style="font-size:.8rem; letter-spacing:1px;">
                                                {{ $acc->investor_password }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge badge-dark" style="font-size:.8rem; letter-spacing:1px;">
                                                {{ $acc->master_password }}
                                            </span>
                                        </td>
                                        <td style="font-size:.8rem;" class="text-muted">
                                            {{ \Carbon\Carbon::parse($acc->created_at)->format('d M Y, h:i A') }}
                                        </td>
                                        <td style="font-size:.8rem;" class="text-muted">
                                            {{ \Carbon\Carbon::parse($acc->updated_at)->format('d M Y, h:i A') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5 text-muted">
                                            @if($search)
                                                <i class="fa fa-search fa-2x mb-2 d-block"></i>
                                                No results for <strong>"{{ $search }}"</strong>
                                            @else
                                                <i class="fa fa-inbox fa-2x mb-2 d-block"></i>
                                                No accounts yet. Import a CSV to get started.
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
