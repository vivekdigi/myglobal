@extends('layouts.app')
@section('content')

    <div class="mt-2 mb-3 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="title1 mb-0">Create Secondary Account</h4>
            <small class="text-muted">Create a second trading account for an existing user</small>
        </div>
        <a href="{{ route('admin.secondary.list') }}" class="btn btn-sm btn-outline-primary" style="border-radius:50px;">
            <i class="fa fa-list mr-1"></i> View All Secondary Accounts
        </a>
    </div>

    <x-admin.alert />

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fa fa-user-plus mr-2"></i>New Secondary Account</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.secondary.store') }}" method="POST" id="createSecondaryForm">
                        @csrf

                        {{-- ── User Search ── --}}
                        <div class="form-group">
                            <label class="font-weight-bold">
                                Select User (Primary Account)
                                <span class="text-danger">*</span>
                            </label>

                            {{-- Search input --}}
                            <div class="input-group mb-2">
                                <input type="text"
                                       id="userSearchInput"
                                       class="form-control"
                                       placeholder="Search by name, email or account ID...">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-primary" id="userSearchBtn">
                                        <i class="fa fa-search"></i> Search
                                    </button>
                                </div>
                            </div>

                            {{-- Search results dropdown --}}
                            <div id="searchResults" class="list-group mb-2" style="display:none; max-height:220px; overflow-y:auto; border:1px solid #ddd; border-radius:4px;"></div>

                            {{-- Hidden selected user --}}
                            <input type="hidden" name="parent_user_id" id="parentUserId" value="{{ $preselect->id ?? '' }}">

                            {{-- Selected user info card --}}
                            <div id="parentInfo" class="alert alert-info py-2 {{ $preselect ? '' : 'd-none' }}">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong id="parentName">{{ $preselect->name ?? '' }}</strong>
                                        &nbsp;|&nbsp;
                                        Account: <strong id="parentAccountId">{{ $preselect->accountid ?? '' }}</strong>
                                        &nbsp;|&nbsp;
                                        <span id="parentEmail" class="text-muted">{{ $preselect->email ?? '' }}</span>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" id="clearUserBtn">
                                        <i class="fa fa-times"></i> Change
                                    </button>
                                </div>
                            </div>

                            @error('parent_user_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- ── New Account ID (readonly) ── --}}
                        <div class="form-group">
                            <label class="font-weight-bold">
                                New Account ID
                                <span class="text-danger">*</span>
                                <small class="text-muted font-weight-normal">(auto-generated, read-only)</small>
                            </label>
                            <input type="text"
                                   name="accountid"
                                   id="accountid"
                                   class="form-control bg-light"
                                   value="{{ old('accountid', $nextAccountId) }}"
                                   readonly>
                            @error('accountid')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- ── Secondary Email ── --}}
                        <div class="form-group">
                            <label class="font-weight-bold">
                                Secondary Account Email
                                <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input type="email"
                                       name="email"
                                       id="secondaryEmail"
                                       class="form-control"
                                       value="{{ old('email') }}"
                                       placeholder="e.g. 2majesty_username@gmail.com"
                                       required>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-secondary" id="autoEmailBtn">
                                        <i class="fa fa-magic"></i> Auto
                                    </button>
                                </div>
                            </div>
                            <small class="text-muted">
                                Auto prefix: <code>2majesty_</code> + parent email
                            </small>
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- ── Investor Password (hidden, auto-fetched from accounts table) ── --}}
                        <input type="hidden" name="investor_password" id="investorPassword" value="{{ old('investor_password') }}">

                        {{-- ── Master Password (hidden, auto-fetched from accounts table) ── --}}
                        <input type="hidden" name="master_password" id="masterPassword" value="{{ old('master_password') }}">

                        {{-- Password info message --}}
                        <div id="passwordInfoBox" class="alert alert-secondary py-2 px-3 d-none" style="font-size:.85rem;">
                            <i class="fa fa-lock mr-1"></i>
                            <strong>Investor & Master passwords</strong> are auto-fetched from the
                            <code>accounts</code> table and will be used as-is.
                            &nbsp;
                            <span id="pwdPreview" class="text-muted"></span>
                        </div>

                        <div id="passwordWarningBox" class="alert alert-warning py-2 px-3 d-none" style="font-size:.85rem;">
                            <i class="fa fa-exclamation-triangle mr-1"></i>
                            No credentials found in <code>accounts</code> table for this user's account ID.
                            The secondary account will be created without passwords.
                        </div>

                        {{-- ── Dashboard Login Password ── --}}
                        <div class="form-group">
                            <label class="font-weight-bold">
                                Dashboard Login Password
                                <span class="text-danger">*</span>
                                <small class="text-muted font-weight-normal">(for secondary account login)</small>
                            </label>
                            <div class="input-group">
                                <input type="text"
                                       name="login_password"
                                       id="loginPassword"
                                       class="form-control"
                                       value="{{ old('login_password', \Illuminate\Support\Str::random(10)) }}"
                                       placeholder="Enter or auto-generate password"
                                       required>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-secondary" id="regenLoginPwdBtn" title="Generate new password">
                                        <i class="fa fa-sync-alt"></i> Generate
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary" id="toggleLoginPwdBtn" title="Show/Hide">
                                        <i class="fa fa-eye" id="toggleLoginPwdIcon"></i>
                                    </button>
                                </div>
                            </div>
                            <small class="text-warning">
                                <i class="fa fa-exclamation-circle mr-1"></i>
                                Save this password — it will be stored as hash and cannot be recovered later.
                            </small>
                            @error('login_password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <hr>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                <i class="fa fa-lock mr-1"></i>
                                This is an internal process. No email will be sent.
                            </small>
                            <button type="submit" class="btn btn-primary px-4" id="submitBtn">
                                <i class="fa fa-user-plus mr-1"></i> Create Account
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
$(document).ready(function () {

    var selectedUserId   = '{{ $preselect->id ?? "" }}';
    var parentEmailStore = '{{ $preselect->email ?? "" }}';

    // Load credentials if preselected
    if (selectedUserId) {
        loadCredentials(selectedUserId);
    }

    // ── Search ──────────────────────────────────────────────────────────────
    function doSearch() {
        var q = $('#userSearchInput').val().trim();
        if (q.length < 2) {
            $('#searchResults').hide().empty();
            return;
        }

        $.get('{{ url("/admin/dashboard/fetchusers") }}', function (data) {
            var users   = data.data || [];
            var keyword = q.toLowerCase();
            var filtered = users.filter(function (u) {
                return (u.name && u.name.toLowerCase().includes(keyword))
                    || (u.email && u.email.toLowerCase().includes(keyword))
                    || (u.accountid && String(u.accountid).includes(keyword));
            }).slice(0, 20);

            var html = '';
            if (filtered.length === 0) {
                html = '<div class="list-group-item text-muted">No users found</div>';
            } else {
                filtered.forEach(function (u) {
                    html += '<button type="button" class="list-group-item list-group-item-action user-result-item" '
                          + 'data-id="' + u.id + '" '
                          + 'data-name="' + u.name + '" '
                          + 'data-email="' + u.email + '" '
                          + 'data-accountid="' + (u.accountid || '') + '">'
                          + '<strong>' + u.name + '</strong>'
                          + ' &nbsp;<span class="badge badge-secondary">' + (u.accountid || 'N/A') + '</span>'
                          + ' &nbsp;<small class="text-muted">' + u.email + '</small>'
                          + '</button>';
                });
            }
            $('#searchResults').html(html).show();
        });
    }

    $('#userSearchBtn').on('click', doSearch);
    $('#userSearchInput').on('keyup', function (e) {
        if (e.key === 'Enter') { doSearch(); }
        else if ($(this).val().length >= 2) { doSearch(); }
        else { $('#searchResults').hide().empty(); }
    });

    // ── Select user from results ─────────────────────────────────────────────
    $(document).on('click', '.user-result-item', function () {
        var id        = $(this).data('id');
        var name      = $(this).data('name');
        var email     = $(this).data('email');
        var accountid = $(this).data('accountid');

        selectedUserId   = id;
        parentEmailStore = email;

        $('#parentUserId').val(id);
        $('#parentName').text(name);
        $('#parentAccountId').text(accountid);
        $('#parentEmail').text(email);
        $('#parentInfo').removeClass('d-none');
        $('#searchResults').hide().empty();
        $('#userSearchInput').val('');

        // Auto email
        var parts = email.split('@');
        $('#secondaryEmail').val('2majesty_' + parts[0] + '@' + parts[1]);

        // Load credentials from accounts table
        loadCredentials(id);
    });

    // ── Load credentials via AJAX ────────────────────────────────────────────
    function loadCredentials(userId) {
        $.get('{{ route("admin.secondary.credentials") }}', { user_id: userId }, function (data) {
            // New secondary account ID (last+1)
            $('#accountid').val(data.next_account_id);

            // Set hidden password fields
            $('#investorPassword').val(data.investor_password || '');
            $('#masterPassword').val(data.master_password || '');

            // Remove old warning
            $('#accountWarning').remove();
            $('#passwordInfoBox').addClass('d-none');
            $('#passwordWarningBox').addClass('d-none');

            if (data.account_found) {
                // Show info message with masked passwords
                var inv = data.investor_password;
                var mst = data.master_password;
                $('#pwdPreview').html(
                    'Investor: <strong>' + inv + '</strong> &nbsp;|&nbsp; Master: <strong>' + mst + '</strong>'
                );
                $('#passwordInfoBox').removeClass('d-none');
            } else {
                $('#passwordWarningBox').removeClass('d-none');
            }

            if (!$('#secondaryEmail').val()) {
                $('#secondaryEmail').val(data.suggested_email);
            }

        }).fail(function () {
            alert('Could not fetch user credentials. Please try again.');
        });
    }

    // ── Auto email button ────────────────────────────────────────────────────
    $('#autoEmailBtn').on('click', function () {
        if (!parentEmailStore) { alert('Please select a user first.'); return; }
        var parts     = parentEmailStore.split('@');
        var accountid = $('#accountid').val();
        $('#secondaryEmail').val('2majesty_' + parts[0] + '_' + accountid + '@' + parts[1]);
    });

    // ── Clear / change user ──────────────────────────────────────────────────
    $('#clearUserBtn').on('click', function () {
        selectedUserId   = '';
        parentEmailStore = '';
        $('#parentUserId').val('');
        $('#parentInfo').addClass('d-none');
        $('#secondaryEmail').val('');
        $('#investorPassword').val('');
        $('#masterPassword').val('');
        $('#passwordInfoBox').addClass('d-none');
        $('#passwordWarningBox').addClass('d-none');
        $('#submitBtn').prop('disabled', true);
        $('#userSearchInput').focus();
    });

    // ── Login Password: Generate ─────────────────────────────────────────────
    $('#regenLoginPwdBtn').on('click', function () {
        var chars = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz23456789@#!';
        var pwd = '';
        for (var i = 0; i < 10; i++) {
            pwd += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        $('#loginPassword').val(pwd).attr('type', 'text');
        $('#toggleLoginPwdIcon').removeClass('fa-eye-slash').addClass('fa-eye');
    });

    // ── Login Password: Show/Hide toggle ────────────────────────────────────
    $('#toggleLoginPwdBtn').on('click', function () {
        var input = $('#loginPassword');
        var icon  = $('#toggleLoginPwdIcon');
        if (input.attr('type') === 'text') {
            input.attr('type', 'password');
            icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            input.attr('type', 'text');
            icon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });

    // ── Close results on outside click ───────────────────────────────────────
    $(document).on('click', function (e) {
        if (!$(e.target).closest('#userSearchInput, #userSearchBtn, #searchResults').length) {
            $('#searchResults').hide();
        }
    });

});
</script>
@endpush
