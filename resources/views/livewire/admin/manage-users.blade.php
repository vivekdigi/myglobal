<div>
    <x-page-title>
        {{ $settings->site_name }} users list
    </x-page-title>
    <x-admin.alert />
    <div class="mb-5 row">
        <div class="col-md-12 ">
            <div class="mb-3">
            <button class="btn btn-secondary" id="exportCsvBtn">CSV Download</button>
            </div>
            <div class="card shadow p-4 ">
                <div class="card-header">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-12 col-xl-8 col-lg-7 mb-2 mb-lg-0">
                            <div class="d-flex align-items-center flex-wrap" style="gap: 8px;">
                                <div style="min-width: 200px;">
                                    <form onsubmit="return false;">
                                        <div class="input-group">
                                            <input wire:model.debounce.500ms='searchvalue'
                                                class="form-control form-control-sm shadow-none search themes/purposeTheme/assets/"
                                                type="search" placeholder="name, username or email" aria-label="search" />
                                        </div>
                                    </form>
                                </div>
                                <div>
                                    <select wire:model='pagenum' class="form-control form-control-sm themes/purposeTheme/assets/" style="width: auto;">
                                        <option value="10">10</option>
                                        <option value="20">20</option>
                                        <option value="50">50</option>
                                        <option value="200">200</option>
                                    </select>
                                </div>
                                <div>
                                    <select wire:model='orderby' class="form-control form-control-sm themes/purposeTheme/assets/" style="width: auto;">
                                        <option value="id">id</option>
                                        <option value="name">Name</option>
                                        <option value="email">Email</option>
                                        <option value="account_bal">Account balance</option>
                                        <option value="created_at">Sign up date</option>
                                    </select>
                                </div>
                                <div>
                                    <select wire:model='orderdirection' class="form-control form-control-sm themes/purposeTheme/assets/" style="width: auto;">
                                        <option value="desc">Descending</option>
                                        <option value="asc">Ascending</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-xl-4 col-lg-5 text-lg-right text-lg-end">
                            @if ($checkrecord)
                                <div class="d-flex justify-content-lg-end flex-wrap align-items-center" style="gap: 6px;">
                                    <div>
                                        <select wire:model='action'
                                            class="form-control themes/purposeTheme/assets/ form-select form-select-sm"
                                            aria-label="Bulk actions">
                                            <option value="Delete">Delete</option>
                                            <option value="Clear">Clear Account</option>
                                        </select>
                                    </div>
                                    <div>
                                        <button class="btn btn-danger btn-sm" wire:click='delsystemuser'
                                            type="button">Apply</button>
                                    </div>
                                    <div>
                                        <button class="btn btn-info btn-sm" data-toggle="modal"
                                            data-target="#TradingModal" type="button">
                                            <span class="fas fa-coins" data-fa-transform="shrink-3 down-2"></span>
                                            <span class="d-none d-sm-inline-block ms-1">Add ROI</span>
                                        </button>
                                    </div>
                                    <div>
                                        <button data-toggle="modal" data-target="#topupModal"
                                            class="btn btn-info btn-sm" type="button">
                                            <span class="fas fa-plus" data-fa-transform="shrink-3 down-2"></span>
                                            <span class="d-none d-sm-inline-block ms-1">Topup</span>
                                        </button>
                                    </div>
                                </div>
                            @else
                                <div class="d-flex justify-content-lg-end" style="gap: 8px;">
                                    <button class="btn btn-primary btn-sm" type="button"
                                        data-toggle="modal" data-target="#adduser">
                                        <span class="fas fa-user-plus" data-fa-transform="shrink-3 down-2"></span>
                                        <span class="d-none d-sm-inline-block ms-1">New User</span>
                                    </button>

                                    <a class="btn btn-info btn-sm" href="{{ route('emailservices') }}">
                                        <span class="fas fa-envelope" data-fa-transform="shrink-3 down-2"></span>
                                        <span class="d-none d-sm-inline-block ms-1">Send Message</span>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive" data-example-id="hoverable-table">
                        <table id="usersTable" class="table table-hover themes/purposeTheme/assets/">
                            <thead>
                                <tr>
                                    <th class="white-space-nowrap">
                                        <input type="checkbox" wire:model='selectPage' />
                                    </th>
                                    <th>Fullname</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Account Id</th>
                                    <th>Investor Password</th>
                                    <th>Master Password </th>
                                    <th>Account Balance</th>
                                    <th>Country</th>
                                    <th>Status</th>
                                    <th>Client Status</th>
                                    <th>Registered</th>
                                    
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="userslisttbl">

                                @forelse ($users as $user)
                                    
                                    <tr>
                                        <td class="align-middle">
                                            <input type="checkbox" wire:model='checkrecord'
                                                value="{{ $user->id }}" />
                                        </td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->username }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->phone }}</td>
                                        <td>{{ $user->accountid }}</td>
                                        <td>{{ $user->investor_password }}</td>
                                        <td>{{ $user->master_password }}</td>
                                        
                                        <td>{{ $settings->currency }}{{ number_format($user->account_bal, 2, '.', ',') }}
                                        </td>
                                        <td>{{ $user->country }}</td>
                                        <td>
                                            @if ($user->status == 'active')
                                                <span class='badge badge-success'>{{ $user->status }}</span>
                                            @else
                                                <span class='badge badge-danger'>{{ $user->status }}</span>
                                            @endif
                                        </td>
                                        <td>
                                        @if ($user->paid_count > 0)
                                        <span class="badge badge-success">Paid</span>
                                        @else
                                        <span class="badge badge-danger">Unpaid</span>
                                        @endif
                                        </td>
                                        <td>
                                            {{ $user->created_at->diffForHumans() }}
                                        </td>
                                        <td>
                                            <a class='btn btn-secondary btn-sm'
                                                href="{{ route('viewuser', $user->id) }}" role='button'>
                                                Manage
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <td colspan="9">
                                        No Data Available
                                    </td>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer py-2">
                    <div class="row flex-between-center align-items-center">
                        <div class="col-auto">
                            <small class="text-muted">
                                Showing {{ $users->firstItem() ?? 0 }} to {{ $users->lastItem() ?? 0 }} of {{ $users->total() ?? 0 }} users
                            </small>
                        </div>
                        <div class="col-auto">
                            {!! $users->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add CSV Export Button -->
    

    <!-- Modal -->
    <div class="modal fade" tabindex="-1" id="adduser" aria-h6ledby="exampleModalh6" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header ">
                    <h3 class="mb-2 d-inline themes/purposeTheme/assets/">Add User</h3>
                    <button type="button" class="close themes/purposeTheme/assets/" data-dismiss="modal"
                        aria-h6="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body ">
                    <div>
                        <form method="POST" wire:submit.prevent='saveUser'>
                            <!-- Form Fields -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- End add user modal --}}

</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var exportBtn = document.getElementById('exportCsvBtn');
        if (exportBtn) {
            exportBtn.addEventListener('click', function() {
                var csv = [];
                var rows = document.querySelectorAll("#usersTable tr");

                for (var i = 0; i < rows.length; i++) {
                    var row = [], cols = rows[i].querySelectorAll("td, th");
                    for (var j = 0; j < cols.length; j++) {
                        var text = cols[j].innerText.trim().replace(/"/g, '""');
                        row.push('"' + text + '"');
                    }
                    csv.push(row.join(","));
                }

                var csvFile = new Blob([csv.join("\n")], { type: 'text/csv;charset=utf-8;' });
                var downloadLink = document.createElement("a");
                downloadLink.href = URL.createObjectURL(csvFile);
                downloadLink.download = "users_list.csv";
                downloadLink.click();
            });
        }
    });
</script>
