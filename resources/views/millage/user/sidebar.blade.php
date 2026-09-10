<!-- Sidebar -->
<div class="sidebar sidebar-style-2" data-background-color="">
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <div class="user">
                <div class="info">
                    <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                        <span>
                            {{ Auth()->user()->name }}
                            <span class="user-level"> {{ auth()->user()->email }}</span>
                        </span>
                    </a>
                </div>
            </div>

            <ul class="nav nav-primary">
                <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li
                    class="nav-item {{ request()->routeIs('deposits') ? 'active' : '' }} {{ request()->routeIs('payment') ? 'active' : '' }} {{ request()->routeIs('pay.crypto') ? 'active' : '' }}">
                    <a href="{{ route('deposits') }}">
                        <i class="fas fa-angle-double-down"></i>
                        <p>Deposit</p>
                    </a>
                </li>

                @if ($mod['investment'] || $mod['cryptoswap'])
                    <li
                        class="nav-item {{ request()->routeIs('withdrawalsdeposits') ? 'active' : '' }} {{ request()->routeIs('withdrawfunds') ? 'active' : '' }}">
                        <a href="{{ route('withdrawalsdeposits') }}">
                            <i class="fas fa-arrow-alt-circle-up "></i>
                            <p>Withdraw</p>
                        </a>
                    </li>
                @endif
                @if ($mod['investment'])
                    <li class="nav-item {{ request()->routeIs('tradinghistory') ? 'active' : '' }}">
                        <a href="{{ route('tradinghistory') }}">
                            <i class="fas fa-history "></i>
                            <p>Withdrawal History</p>
                        </a>
                    </li>
                @endif
                <li class="nav-item {{ request()->routeIs('accounthistory') ? 'active' : '' }}">
                    <a href="{{ route('accounthistory') }}">
                        <i class="fas fa-money-check-alt "></i>
                        <p>Transactions</p>
                    </a>
                </li>
                @if ($moresettings->use_transfer)
                    <li class="nav-item {{ request()->routeIs('transferview') ? 'active' : '' }}">
                        <a href="{{ route('transferview') }}">
                            <i class="fas fa-bezier-curve"></i>
                            <p>Transfer funds</p>
                        </a>
                    </li>
                @endif

                @if ($mod['investment'])
                    <li class="nav-item {{ request()->routeIs('mplans') ? 'active' : '' }}">
                        <a href="{{ route('mplans') }}">
                            <i class="fas fa-clipboard-list"></i>
                            <p>Trading Plans</p>
                        </a>

                    </li>
                    <li
                        class="nav-item {{ request()->routeIs('myplans') ? 'active' : '' }} {{ request()->routeIs('plandetails') ? 'active' : '' }}">
                        <a href="{{ route('myplans', 'All') }}">
                            <i class="fas fa-cube"></i>
                            <p>My Plans</p>
                        </a>
                    </li>
                @endif

                @if ($mod['cryptoswap'])
                    <li
                        class="nav-item {{ request()->routeIs('assetbalance') ? 'active' : '' }} {{ request()->routeIs('swaphistory') ? 'active' : '' }}">
                        <a href="{{ route('assetbalance') }}">
                            <i class="fab fa-stack-exchange "></i>
                            <p>Swap Crypto</p>
                        </a>
                    </li>
                @endif

                @if ($mod['subscription'])
                    <li class="nav-item {{ request()->routeIs('subtrade') ? 'active' : '' }}">
                        <a href="{{ route('subtrade') }}">
                            <i class="fas fa-layer-group"></i>
                            <p>Copytrading</p>
                        </a>
                    </li>
                @endif
                @if ($mod['signal'])
                    <li class="nav-item {{ request()->routeIs('tsignals') ? 'active' : '' }}">
                        <a href="{{ route('tsignals') }}">
                            <i class="fas fa-rss"></i>
                            <p>Trade Signals</p>
                        </a>
                    </li>
                @endif
                @if ($mod['membership'])
                    <li
                        class="nav-item {{ request()->routeIs('user.mycourses') ? 'active' : '' }} {{ request()->routeIs('user.courses') ? 'active' : '' }} {{ request()->routeIs('user.course.details') ? 'active' : '' }}">
                        <a href="{{ route('user.courses') }}">
                            <i class="fas fa-graduation-cap "></i>
                            <p>Education</p>
                        </a>
                    </li>
                @endif
                <li class="nav-item {{ request()->routeIs('referuser') ? 'active' : '' }}">
                    <a href="{{ route('referuser') }}">
                        <i class="fas fa-retweet "></i>
                        <p>Referrals</p>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('support') ? 'active' : '' }}">
                    <a href="{{ route('support') }}" class="btn btn-sm btn-block btn-white rounded-pill">
                        <i class="fa fa-envelope "></i>
                        <p> Contact Us</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- End Sidebar -->
