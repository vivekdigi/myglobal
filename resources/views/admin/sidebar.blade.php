<!-- Stored in resources/views/child.blade.php -->

<!-- Sidebar -->
<div class="sidebar sidebar-style-2" data-background-color="{{ Auth('admin')->User()->dashboard_style }}">
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <div class="user">
                <div class="info">
                    <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                        <span>
                            {{ Auth('admin')->User()->firstName }} {{ Auth('admin')->User()->lastName }}
                            <span class="user-level"> Admin</span>
                            {{-- <span class="caret"></span> --}}
                        </span>
                    </a>
                </div>
            </div>

            <ul class="nav nav-primary">
                <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <a href="{{ url('/admin/dashboard') }}">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                @if (Auth('admin')->User()->type == 'Super Admin' || Auth('admin')->User()->type == 'Admin')
                    @if ($mod['investment'])
                        <li
                            class="nav-item {{ request()->routeIs('plans') ? 'active' : '' }} {{ request()->routeIs('newplan') ? 'active' : '' }} {{ request()->routeIs('editplan') ? 'active' : '' }} {{ request()->routeIs('activeinvestments') ? 'active' : '' }}">
                            <a data-toggle="collapse" href="#pln">
                                <i class="fas fa-cubes "></i>
                                <p>Investment</p>
                                <span class="caret"></span>
                            </a>
                            <div class="collapse" id="pln">
                                <ul class="nav nav-collapse">
                                    <li>
                                        <a href="{{ url('/admin/dashboard/plans') }}">
                                            <span class="sub-item">Investment Plans</span>
                                        </a>
                                    </li>
                                    <!-- <li>
                                        <a href="{{ url('/admin/dashboard/active-investments') }}">
                                            <span class="sub-item">Active Investments</span>
                                        </a>
                                    </li> -->
                                </ul>
                            </div>
                        </li>
                    @endif
                    <li
                        class="nav-item {{ request()->routeIs('manageusers') ? 'active' : '' }} {{ request()->routeIs('loginactivity') ? 'active' : '' }} {{ request()->routeIs('user.plans') ? 'active' : '' }} {{ request()->routeIs('viewuser') ? 'active' : '' }}">
                        <a data-toggle="collapse" href="#usermenu">
                            <i class="fa fa-user-circle" aria-hidden="true"></i>
                            <p>Manage Users <span class="caret"></span></p>
                        </a>
                        <div class="collapse {{ request()->routeIs('manageusers') ? 'show' : '' }}" id="usermenu">
                            <ul class="nav nav-collapse">
                                <li>
                                    <a href="{{ url('/admin/dashboard/manageusers') }}">
                                        <span class="sub-item">All Users</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item {{ request()->routeIs('mdeposits') ? 'active' : '' }}">
                        <a href="{{ route('mdeposits') }}">
                            <i class="fa fa-download" aria-hidden="true"></i>
                            <p>Manage Deposits</p>
                        </a>
                    </li>

                    <li
                        class="nav-item {{ request()->routeIs('mwithdrawals') ? 'active' : '' }}   {{ request()->routeIs('processwithdraw') ? 'active' : '' }}">
                        <a href="{{ url('/admin/dashboard/mwithdrawals') }}">
                            <i class="fa fa-arrow-alt-circle-up" aria-hidden="true"></i>
                            <p>Manage Withdrawal</p>
                        </a>
                    </li>

                    <li
                        class="nav-item {{ request()->routeIs('kyc') ? 'active' : '' }} {{ request()->routeIs('viewkyc') ? 'active' : '' }}">
                        <a href="{{ route('kyc') }}">
                            <i class="fa fa-user-check" aria-hidden="true"></i>
                            <p>KYC Application(s)</p>
                        </a>
                    </li>

                    <li class="nav-item {{ request()->routeIs('admin.referrals.overview') ? 'active' : '' }}" >
                        <a href="{{ route('admin.referrals.overview') }}">
                            <i class="fa fa-users" aria-hidden="true"></i>
                            <p>Referral Overview</p>
                        </a>
                    </li>

                    <li class="nav-item {{ request()->routeIs('admin.accounts.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.accounts.index') }}">
                            <i class="fa fa-database" aria-hidden="true"></i>
                            <p>Accounts</p>
                        </a>
                    </li>

                    <li class="nav-item {{ request()->routeIs('admin.demo.requests') ? 'active' : '' }}">
                        <a href="{{ route('admin.demo.requests') }}">
                            <i class="fa fa-flask" aria-hidden="true"></i>
                            <p>Demo Requests
                                @if (!empty($pendingDemoCount) && $pendingDemoCount > 0)
                                    <span class="badge badge-danger ml-1">{{ $pendingDemoCount }}</span>
                                @endif
                            </p>
                        </a>
                    </li>

                    {{-- 2nd Account Requests --}}
                    <li class="nav-item {{ request()->routeIs('admin.second.*') || request()->routeIs('admin.secondary.*') ? 'active' : '' }}">
                        <a data-toggle="collapse" href="#secondacct">
                            <i class="fa fa-user-plus" aria-hidden="true"></i>
                            <p>2nd Account Requests
                                @if (!empty($pendingSecondCount) && $pendingSecondCount > 0)
                                    <span class="badge badge-danger ml-1">{{ $pendingSecondCount }}</span>
                                @endif
                                <span class="caret"></span>
                            </p>
                        </a>
                        <div class="collapse {{ request()->routeIs('admin.second.*') || request()->routeIs('admin.secondary.*') ? 'show' : '' }}" id="secondacct">
                            <ul class="nav nav-collapse">
                                <li>
                                    <a href="{{ route('admin.second.requests') }}">
                                        <span class="sub-item">Requests
                                            @if (!empty($pendingSecondCount) && $pendingSecondCount > 0)
                                                <span class="badge badge-danger ml-1">{{ $pendingSecondCount }}</span>
                                            @endif
                                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.secondary.list') }}">
                                        <span class="sub-item">All 2nd Accounts</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.secondary.create') }}">
                                        <span class="sub-item">Create 2nd Account</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    {{-- 3rd Account Requests --}}
                    <li class="nav-item {{ request()->routeIs('admin.third.*') ? 'active' : '' }}">
                        <a data-toggle="collapse" href="#thirdacct">
                            <i class="fa fa-user-plus" aria-hidden="true"></i>
                            <p>3rd Account Requests
                                <span class="caret"></span>
                            </p>
                        </a>
                        <div class="collapse {{ request()->routeIs('admin.third.*') ? 'show' : '' }}" id="thirdacct">
                            <ul class="nav nav-collapse">
                                <li>
                                    <a href="{{ route('admin.third.list') }}">
                                        <span class="sub-item">All 3rd Accounts</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.third.create') }}">
                                        <span class="sub-item">Create 3rd Account</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    {{-- 4th Account Requests --}}
                    <li class="nav-item {{ request()->routeIs('admin.fourth.*') ? 'active' : '' }}">
                        <a data-toggle="collapse" href="#fourthacct">
                            <i class="fa fa-user-plus" aria-hidden="true"></i>
                            <p>4th Account Requests
                                <span class="caret"></span>
                            </p>
                        </a>
                        <div class="collapse {{ request()->routeIs('admin.fourth.*') ? 'show' : '' }}" id="fourthacct">
                            <ul class="nav nav-collapse">
                                <li>
                                    <a href="{{ route('admin.fourth.list') }}">
                                        <span class="sub-item">All 4th Accounts</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.fourth.create') }}">
                                        <span class="sub-item">Create 4th Account</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    @if ($mod['subscription'])
                        <li @class([
                            'nav-item ',
                            'active' =>
                                request()->routeIs('msubtrade') ||
                                request()->routeIs('tsettings') ||
                                request()->routeIs('subview') ||
                                request()->routeIs('symbolmaps') ||
                                request()->routeIs('admin.invoices'),
                        ])>
                            <a data-toggle="collapse" href="#mgacnt">
                                <i class="fa fa-sync-alt"></i>
                                <p>MAM - Copytrading</p>
                                <span class="caret"></span>
                            </a>
                            <div class="collapse" id="mgacnt">
                                <ul class="nav nav-collapse">
                                    <li>
                                        <a href="{{ route('tsettings') }}">
                                            <span class="sub-item">Provider accounts</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('msubtrade') }}">
                                            <span class="sub-item">Followers accounts</span>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{ route('symbolmaps') }}">
                                            <span class="sub-item">Symbol Maps</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('subview') }}">
                                            <span class="sub-item">Settings</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @endif
                    @if ($mod['signal'])
                        <li
                            class="nav-item {{ request()->routeIs('signals') ? 'active' : '' }} {{ request()->routeIs('signal.settings') ? 'active' : '' }} {{ request()->routeIs('signal.subs') ? 'active' : '' }}">
                            <a data-toggle="collapse" href="#signals">
                                <i class="fa fa-signal"></i>
                                <p>Signal Provider</p>
                                <span class="caret"></span>
                            </a>
                            <div class="collapse" id="signals">
                                <ul class="nav nav-collapse">
                                    <li>
                                        <a href="{{ route('signals') }}">
                                            <span class="sub-item">Trade Signals</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('signal.subs') }}">
                                            <span class="sub-item">Subscribers</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('signal.settings') }}">
                                            <span class="sub-item">Settings</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @endif
                    @if ($mod['membership'])
                        <li
                            class="nav-item {{ request()->routeIs('categories') ? 'active' : '' }} {{ request()->routeIs('courses') ? 'active' : '' }} {{ request()->routeIs('lessons') ? 'active' : '' }}">
                            <a data-toggle="collapse" href="#meme">
                                <i class="fa fa-book-reader"></i>
                                <p>Membership</p>
                                <span class="caret"></span>
                            </a>
                            <div class="collapse" id="meme">
                                <ul class="nav nav-collapse">
                                    <li>
                                        <a href="{{ route('categories') }}">
                                            <span class="sub-item">Categories</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('courses') }}">
                                            <span class="sub-item">Courses</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('less.nocourse') }}">
                                            <span class="sub-item">Lessons</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @endif
                @endif
                <li
                    class="nav-item {{ request()->routeIs('task') ? 'active' : '' }} {{ request()->routeIs('mtask') ? 'active' : '' }} {{ request()->routeIs('viewtask') ? 'active' : '' }}">
                    <a data-toggle="collapse" href="#task">
                        <i class="fas fa-align-center"></i>
                        <p>CRM</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="task">
                        <ul class="nav nav-collapse">
                            @if (Auth('admin')->User()->type == 'Super Admin')
                                <li>
                                    <a href="{{ url('/admin/dashboard/task') }}">
                                        <span class="sub-item">Create Task</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('/admin/dashboard/mtask') }}">
                                        <span class="sub-item">Manage Tasks</span>
                                    </a>
                                </li>
                            @endif
                            @if (Auth('admin')->User()->type != 'Super Admin')
                                <li>
                                    <a href="{{ url('/admin/dashboard/viewtask') }}">
                                        <span class="sub-item">View my Tasks</span>
                                    </a>
                                </li>
                            @endif

                            @if (Auth('admin')->User()->type == 'Super Admin' || Auth('admin')->User()->type == 'Admin')
                                <li class=" {{ request()->routeIs('leads') ? 'active' : '' }}">
                                    <a href="{{ url('/admin/dashboard/leads') }}">
                                        <!-- <i class="fas fa-user-slash " aria-hidden="true"></i> -->
                                        <span class="sub-item">Leads</span>
                                    </a>
                                </li>

                                <li class=" {{ request()->routeIs('emailservices') ? 'active' : '' }}">
                                    <a href="{{ route('emailservices') }}">
                                        <!-- <i class="fa fa-envelope" aria-hidden="true"></i> -->
                                        <span class="sub-item">Email Services</span>
                                    </a>
                                </li>
                            @endif

                            @if (Auth('admin')->User()->type == 'Rentention Agent' || Auth('admin')->User()->type == 'Conversion Agent')
                                <li class="nav-item {{ request()->routeIs('leadsassign') ? 'active' : '' }}">
                                    <a href="{{ url('/admin/dashboard/leadsassign') }}">
                                        <i class="fas fa-user-slash " aria-hidden="true"></i>
                                        <p>My Leads</p>
                                    </a>
                                </li>
                            @endif

                        </ul>
                    </div>
                </li>

                @if (Auth('admin')->User()->type == 'Super Admin')
                    <li
                        class="nav-item {{ request()->routeIs('addmanager') ? 'active' : '' }} {{ request()->routeIs('madmin') ? 'active' : '' }}">
                        <a data-toggle="collapse" href="#adm">
                            <i class="fa fa-user"></i>
                            <p>Administrator(s)</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="adm">
                            <ul class="nav nav-collapse">
                                <li>
                                    <a href="{{ url('/admin/dashboard/addmanager') }}">
                                        <span class="sub-item">Add Manager</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('/admin/dashboard/madmin') }}">
                                        <span class="sub-item">Manage Admin(s)</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li
                        class="nav-item {{ request()->routeIs('appsettingshow') ? 'active' : '' }} {{ request()->routeIs('termspolicy') ? 'active' : '' }} {{ request()->routeIs('refsetshow') ? 'active' : '' }} {{ request()->routeIs('paymentview') ? 'active' : '' }} {{ request()->routeIs('frontpage') ? 'active' : '' }} {{ request()->routeIs('allipaddress') ? 'active' : '' }} {{ request()->routeIs('ipaddress') ? 'active' : '' }} {{ request()->routeIs('editpaymethod') ? 'active' : '' }} {{ request()->routeIs('managecryptoasset') ? 'active' : '' }}">
                        <a data-toggle="collapse" href="#settings">
                            <i class="fa fa-cog"></i>
                            <p>Settings</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="settings">
                            <ul class="nav nav-collapse">
                                <li>
                                    <a href="{{ route('appsettingshow') }}">
                                        <span class="sub-item">App Settings</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('refsetshow') }}">
                                        <span class="sub-item">Referral/Bonus Settings</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('paymentview') }}">
                                        <span class="sub-item">Payment Settings</span>
                                    </a>
                                </li>
                                @if ($mod['cryptoswap'])
                                    <li>
                                        <a href="{{ route('managecryptoasset') }}">
                                            <span class="sub-item">Swap Settings</span>
                                        </a>
                                    </li>
                                @endif
                                <li>
                                    <a href="{{ url('/admin/dashboard/frontpage') }}">
                                        <span class="sub-item">Frontend Settings</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('termspolicy') }}">
                                        <span class="sub-item">Terms and Privacy</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('/admin/dashboard/ipaddress') }}">
                                        <span class="sub-item">IP Blacklist</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endif

                @if (Auth('admin')->User()->type != 'Conversion Agent')
                    <li @class([
                        'nav-item',
                        'active' => request()->routeIs('aboutonlinetrade'),
                    ])>
                        <a href="{{ url('/admin/dashboard/platform') }}">
                            <i class=" fa fa-info-circle" aria-hidden="true"></i>
                            <p>Platform</p>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</div>
<!-- End Sidebar -->
