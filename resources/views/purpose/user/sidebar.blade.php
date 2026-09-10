<!-- Sidenav -->
<div class="sidenav" id="sidenav-main">
    <!-- Sidenav header -->
    <div class="sidenav-header d-flex align-items-center" style="margin-top:40px">
        <a class="navbar-brand" href="{{ route('dashboard') }}">
            <!-- <img src="{{ asset('images/logo/logowh.png') }}" class="navbar-brand-img" alt="logo"> -->
        </a>
        <div class="ml-auto">
            <!-- Sidenav toggler -->
            <div class="sidenav-toggler sidenav-toggler-dark d-md-none" data-action="sidenav-unpin"
                data-target="#sidenav-main">
                <div class="sidenav-toggler-inner">
                    <i class="bg-white sidenav-toggler-line"></i>
                    <i class="bg-white sidenav-toggler-line"></i>
                    <i class="bg-white sidenav-toggler-line"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- User mini profile -->
    <div class="text-center sidenav-user d-flex flex-column align-items-center justify-content-between">
        <div>
            <a href="#" class="avatar rounded-circle avatar-xl">
                <i class="fas fa-user-circle fa-4x"></i>
            </a>
            <div class="mt-4">
                <h5 class="mb-0 text-white">{{ Auth::user()->name }}</h5>
                <span class="mb-3 text-sm text-white d-block opacity-8">online</span>
                <a href="#" class="shadow btn btn-sm btn-white btn-icon rounded-pill hover-translate-y-n3">
                    <span class="btn-inner--icon"><i class="far fa-coins"></i></span>
                    <span class="btn-inner--text">
                        {{ $settings->currency }}{{ number_format(Auth::user()->account_bal, 2, '.', ',') }}
                    </span>
                </a>
            </div>
        </div>
    </div>

    <!-- Application nav -->
    <div class="clearfix nav-application">
        <a href="{{ route('dashboard') }}"
            class="text-sm btn btn-square {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <span class="btn-inner--icon d-block"><i class="far fa-home fa-2x"></i></span>
            <span class="pt-2 btn-inner--icon d-block">Home</span>
        </a>

        <a href="{{ route('deposits') }}"
            class="text-sm btn btn-square {{ request()->routeIs('deposits') ? 'active' : '' }} {{ request()->routeIs('payment') ? 'active' : '' }} {{ request()->routeIs('pay.crypto') ? 'active' : '' }}">
            <span class="btn-inner--icon d-block"><i class="far fa-download fa-2x"></i></span>
            <span class="pt-2 btn-inner--icon d-block">Deposit</span>
        </a>

        @if ($mod['investment'] || $mod['cryptoswap'])
            <a href="{{ route('withdrawalsdeposits') }}"
                class="text-sm btn btn-square {{ request()->routeIs('withdrawalsdeposits') ? 'active' : '' }} {{ request()->routeIs('withdrawfunds') ? 'active' : '' }}">
                <span class="btn-inner--icon d-block"><i class="fas fa-arrow-alt-circle-up fa-2x"></i></span>
                <span class="pt-2 btn-inner--icon d-block">Withdraw</span>
            </a>
        @endif

        <!-- @if ($mod['investment'])
            <a href="{{ route('tradinghistory') }}"
                class="text-sm btn btn-square {{ request()->routeIs('tradinghistory') ? 'active' : '' }}">
                <span class="btn-inner--icon d-block"><i class="fal fa-history fa-2x"></i></span>
                <span class="pt-2 btn-inner--icon d-block">Withdrawal History</span>
            </a>
        @endif -->

        <a href="{{ route('accounthistory') }}"
            class="text-sm btn btn-square {{ request()->routeIs('accounthistory') ? 'active' : '' }}">
            <span class="btn-inner--icon d-block"><i class="fas fa-money-check-alt fa-2x"></i></span>
            <span class="pt-2 btn-inner--icon d-block">Transactions</span>
        </a>

        @if ($moresettings->use_transfer)
            <a href="{{ route('transferview') }}"
                class="text-sm btn btn-square {{ request()->routeIs('transferview') ? 'active' : '' }}">
                <span class="btn-inner--icon d-block"><i class="fas fa-exchange fa-2x"></i></span>
                <span class="pt-2 btn-inner--icon d-block">Transfer funds</span>
            </a>
        @endif

        @if ($mod['subscription'])
            <a href="{{ route('subtrade') }}"
                class="text-sm btn btn-square {{ request()->routeIs('subtrade') ? 'active' : '' }}">
                <span class="btn-inner--icon d-block"><i class="far fa-receipt fa-2x"></i></span>
                <span class="pt-2 btn-inner--icon d-block">Copytrading</span>
            </a>
        @endif

        @if ($mod['signal'])
            <a href="{{ route('tsignals') }}"
                class="text-sm btn btn-square {{ request()->routeIs('tsignals') ? 'active' : '' }}">
                <span class="btn-inner--icon d-block"><i class="fas fa-wave-square fa-2x"></i></span>
                <span class="pt-2 btn-inner--icon d-block">Trade Signals</span>
            </a>
        @endif

        @if ($mod['membership'])
            <a href="{{ route('user.courses') }}"
                class="text-sm btn btn-square {{ request()->routeIs('user.mycourses') ? 'active' : '' }} {{ request()->routeIs('user.courses') ? 'active' : '' }} {{ request()->routeIs('user.course.details') ? 'active' : '' }}">
                <span class="btn-inner--icon d-block"><i class="fas fa-graduation-cap fa-2x"></i></span>
                <span class="pt-2 btn-inner--icon d-block">Education</span>
            </a>
        @endif

        <a href="{{ route('referuser') }}"
            class="text-sm btn btn-square {{ request()->routeIs('referuser') ? 'active' : '' }}">
            <span class="btn-inner--icon d-block"><i class="fas fa-retweet fa-2x"></i></span>
            <span class="pt-2 btn-inner--icon d-block">Referrals</span>
        </a>
    </div>

    <!-- Misc area -->
    <div class="card bg-gradient-warning">
        <div class="card-body">
            <h5 class="text-white">Need Help!</h5>
            <p class="mb-4 text-white">
                Contact our 24/7 customer support center
            </p>
            <a href="{{ route('support') }}" class="btn btn-sm btn-block btn-white rounded-pill">Contact Us</a>
        </div>
    </div>
</div>


<style>
/* .navbar-brand {
    background: #fff !important;
} */
.application .sidenav-header .navbar-brand img {
    height: 3.5rem;
}
.alert-info {
    color: #d6940d;
    border-color: #000;
    background-color: #000;
}
@media (max-width: 991px) {
    /* .sidenav {
        position: fixed;
        z-index: 2000 !important;
    } */

    .sidenav-mask,
    .g-sidenav-show::before {
        pointer-events: none !important;
    }
}
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Remove overlay mask click block
    const sidenavMask = document.querySelector('.sidenav-mask');
    if (sidenavMask) {
        sidenavMask.addEventListener('click', () => {
            document.body.classList.remove('g-sidenav-show');
        });
    }

    // Auto close sidenav on mobile link click
    document.querySelectorAll('#sidenav-main a[href]').forEach(link => {
        link.addEventListener('click', () => {
            if (window.innerWidth <= 991) {
                document.body.classList.remove('g-sidenav-show');
            }
        });
    });
});
</script>
