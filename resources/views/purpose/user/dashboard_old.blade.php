@extends('layouts.dash')
@section('title', $title)
@section('content')

    <!-- Page title -->
    <div class="page-title">
        <div class="row justify-content-between align-items-center">
            <div class="mb-3 col-md-6 mb-md-0">
                <h5 class="mb-0 text-white h3 font-weight-400">Welcome, {{ Auth::user()->name }}! </br>Account Id : {{ Auth::user()->accountid }}  @if (!empty(Auth::user()->accountid_sec)), {{ Auth::user()->accountid_sec }} @endif </h5><p> (Please check your email for login credentials)</p>
            </div>
            <div class="mb-3 col-md-6 mb-md-0 text-md-right">
                <x-demo-account-btn :demoRequest="$demo_request" />
                <!-- <x-second-account-btn :secondRequest="$second_request" /> -->
            </div>
        </div>
    </div>
    <x-danger-alert />
    <x-success-alert />
    @if (!empty($settings->welcome_message))
        <div class="row">
            <div class="col-12">
                <div class="py-4 alert alert-primary alert-dismissible fade show" role="alert">
                    {{ $settings->welcome_message }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        </div>
    @endif
    @if ($settings->enable_annoc == 'on' and !empty($settings->newupdate))
        <div class="row">
            <div class="col-12">
                <div class="py-4 alert alert-info alert-dismissible fade show" role="alert">
                    {{ $settings->newupdate }} <span class="offer-text">Offer</span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="nk-block-head-content">
                                <h5 class="text-primary h5">Account Summary</h5>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-6">
                            <div class="card card-stats">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h6 class="mb-1 text-muted">Account balance</h6>
                                            <span
                                                class="mb-0 h5 font-weight-bold">{{ $settings->currency }}{{ number_format(Auth::user()->account_bal, 2, '.', ',') }}</span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="text-white icon bg-gradient-primary rounded-circle icon-shape">
                                                <i class="fas fa-sack-dollar"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- @if ($mod['investment'])
                            <div class="col-xl-4 col-md-6">
                                <div class="card card-stats">
                                    
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col">
                                                <h6 class="mb-1 text-muted">Total Profit</h6>
                                                <span
                                                    class="mb-0 h5 font-weight-bold">{{ $settings->currency }}{{ number_format(Auth::user()->roi, 2, '.', ',') }}</span>
                                            </div>
                                            <div class="col-auto">
                                                <div class="text-white icon bg-gradient-primary rounded-circle icon-shape">
                                                    <i class="fas fa-coins"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif -->
                        <div class="col-xl-4 col-md-6">
                            <div class="card card-stats">
                               
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h6 class="mb-1 text-muted">Bonus</h6>
                                            <span
                                                class="mb-0 h5 font-weight-bold">{{ $settings->currency }}{{ number_format(Auth::user()->bonus, 2, '.', ',') }}</span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="text-white icon bg-gradient-primary rounded-circle icon-shape">
                                                <i class="fas fa-gift"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 

                        @if ($mod['subscription'])
                            <div class="col-xl-4 col-md-6">
                                <div class="card card-stats">
                                    <!-- Card body -->
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col">
                                                <h6 class="mb-1 text-muted">Trading Accounts</h6>
                                                <span class="mb-0 h5 font-weight-bold">{{ $trading_accounts }}</span>
                                            </div>
                                            <div class="col-auto">
                                                <div class="text-white icon bg-gradient-primary rounded-circle icon-shape">
                                                    <i class="fas fa-th-list"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="col-xl-4 col-md-6">
                            <div class="card card-stats">
                                <!-- Card body -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h6 class="mb-1 text-muted">Referral Bonus</h6>
                                            <span
                                                class="mb-0 h5 font-weight-bold">{{ $settings->currency }}{{ number_format(Auth::user()->ref_bonus, 2, '.', ',') }}</span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="text-white icon bg-gradient-primary rounded-circle icon-shape">
                                                <i class="fas fa-gifts"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-6">
                            <div class="card card-stats">
                                <!-- Card body -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h6 class="mb-1 text-muted">Total Deposit</h6>
                                            <span class="mb-0 h5 font-weight-bold">
                                                <span
                                                    class="mb-0 h5 font-weight-bold ">{{ $settings->currency }}{{ number_format($deposited, 2, '.', ',') }}
                                                </span>
                                            </span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="text-white icon bg-gradient-primary rounded-circle icon-shape">
                                                <i class="fas fa-arrow-alt-circle-down"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if ($mod['investment'] || $mod['cryptoswap'])
                            <div class="col-xl-4 col-md-6">
                                <div class="card card-stats">
                                    <!-- Card body -->
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col">
                                                <h6 class="mb-1 text-muted">Total Withdrawal</h6>
                                                <span class="mb-0 h5 font-weight-bold">
                                                    {{ $settings->currency }}{{ number_format($total_withdrawal, 2, '.', ',') }}
                                                </span>
                                            </div>
                                            <div class="col-auto">
                                                <div class="text-white icon bg-gradient-primary rounded-circle icon-shape">
                                                    <i class="fas fa-arrow-circle-up"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="row d-none d-lg-block">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                    <div class="card-title">
                                        <h5>Fundamental & Technical Outlook</h5>
                                        <marquee behavior="scroll" direction="left" scrollamount="4" class="text-warning bg-dark py-2 rounded">
                                        {{ $settings->description }}
                                        </marquee>
                                    </div>
                                </div>
                                <div class="card-header d-flex justify-content-between">
                                    <div class="card-title">
                                        <h5>Technical Levels</h5>
                                        <marquee behavior="scroll" direction="left" scrollamount="4" class="text-warning bg-dark py-2 rounded">
                                        {{ $settings->tawk_to }}
                                        </marquee>
                                    </div>
                                </div>
                                
                                <div class="card-header d-flex justify-content-between">
                                    <div class="card-title">
                                    <h5>Latest news</h5>
                                    <marquee behavior="scroll" direction="left" scrollamount="4" class="text-warning bg-dark py-2 rounded">
                                    {{ $settings->merchant_key }}
                                    </marquee>
                                     
                                    </div>
                                </div>
                                <div class="card-body">
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="home-tab" data-toggle="tab"
                                                data-target="#home" type="button" role="tab" aria-controls="home"
                                                aria-selected="true" style="color:#222; padding:5px;">Track all
                                                markets</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="profile-tab" data-toggle="tab"
                                                data-target="#profile" type="button" role="tab"
                                                aria-controls="profile" aria-selected="false" style="color:#222; padding:5px;">Personal
                                                trading chart</button>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTabContent"></br>
                                        <p>Forex Market Live Prices</p></br>
                                        <div class="tab-pane fade show active" id="home" role="tabpanel"
                                            aria-labelledby="home-tab">
                                            <!-- TradingView Widget BEGIN -->
                                            <div class="tradingview-widget-container">
                                                <div class="tradingview-widget-container__widget"></div>
                                                <div class="tradingview-widget-copyright"></div>
                                                <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-forex-cross-rates.js"
                                                    async>
                                                    {
                                                        "width": "100%",
                                                        "height": "550",
                                                        "currencies": [
                                                            "EUR",
                                                            "USD",
                                                            "JPY",
                                                            "GBP",
                                                            "CHF",
                                                            "AUD",
                                                            "CAD",
                                                            "NZD",
                                                            "CNY",
                                                            "TRY",
                                                            "SEK",
                                                            "NOK"
                                                        ],
                                                        "isTransparent": true,
                                                        "colorTheme": "light",
                                                        "locale": "en"
                                                    }
                                                </script>
                                                
                                            </div>
                                            <!-- TradingView Widget END -->
                                        </div>
                                        <div class="tab-pane fade" id="profile" role="tabpanel"
                                            aria-labelledby="profile-tab">
                                            <div class="tradingview-widget-container">
                                                <div id="tradingview_f933e"></div>
                                                <div class="tradingview-widget-copyright">

                                                    <script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>
                                                    <script type="text/javascript">
                                                        new TradingView.widget({
                                                            "width": "100%",
                                                            "height": "550",
                                                            "symbol": "COINBASE:BTCUSD",
                                                            "interval": "1",
                                                            "timezone": "Etc/UTC",
                                                            "theme": 'light',
                                                            "style": "9",
                                                            "locale": "en",
                                                            "toolbar_bg": "#f1f3f6",
                                                            "enable_publishing": false,
                                                            "hide_side_toolbar": false,
                                                            "allow_symbol_change": true,
                                                            "calendar": false,
                                                            "studies": [
                                                                "BB@tv-basicstudies"
                                                            ],
                                                            "container_id": "tradingview_f933e"
                                                        });
                                                    </script>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if ($mod['investment'])
                        {{-- Active Investment plans section --}}
                        <div class="mt-4 row">
                            <!-- <div class="col-12">
                                <div class="nk-block-head-content">
                                    {{-- <h5 class="text-white h5 d-md-block d-none">Recent Plan(s) <span class="text-base count">(2)</span></h5> --}}
                                    <h5 class="text-primary h5">Active Plan(s) <span
                                            class="text-base count">({{ $plans ? count($plans) : '0' }})</span></h5>
                                </div>
                            </div> -->
                            <div class="col-12">
                                @forelse ($plans as $plan)
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="py-4 card">
                                                <div class="card-body d-flex justify-content-between align-items-center">

                                                    <div class="">
                                                        <h6 class="text-black h6">{{ $plan->dplan->name }}</h6>
                                                        <p class="text-muted">Amount - <span
                                                                class="amount">{{ $settings->currency }}{{ number_format($plan->amount) }}</span>
                                                        </p>
                                                    </div>
                                                    <div class="d-none d-md-block">
                                                        <div class="d-flex justify-content-around">
                                                            <div class="mr-3">
                                                                <h6 class="text-black bold">
                                                                    {{ $plan->created_at->toDayDateTimeString() }}
                                                                </h6>
                                                                <span class="nk-iv-scheme-value date">Start Date</span>
                                                            </div>
                                                            <i class="fas fa-arrow-right text-muted"></i>
                                                            <div class="ml-3">
                                                                <h6 class="text-black bold">
                                                                    {{ \Carbon\Carbon::parse($plan->expire_date)->toDayDateTimeString() }}
                                                                </h6>
                                                                <span class="nk-iv-scheme-value date">End Date</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div>
                                                        <h6 class="text-black">
                                                            @if ($plan->active == 'yes')
                                                                <span class="badge badge-success">Active</span>
                                                            @elseif($plan->active == 'expired')
                                                                <span class="badge badge-danger">Expired</span>
                                                            @else
                                                                <span class="badge badge-danger">Inactive</span>
                                                            @endif
                                                        </h6>
                                                        <span class="nk-iv-scheme-value amount">Status</span>
                                                    </div>

                                                    <a href="{{ route('plandetails', $plan->id) }}">
                                                        <i class="fas fa-chevron-right fa-2x"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                @empty
                                    <!-- <div class="mt-4 row">
                                        <div class="col-md-12">
                                            <div class="py-4 card">
                                                <div class="text-center card-body">
                                                    <p>You do not have an active investment plan at the moment.</p>
                                                    <a href="{{ route('mplans') }}" class="px-3 btn btn-primary">Buy a
                                                        plan</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->
                                @endforelse
                                @if (count($plans) > 0)
                                    <div class="text-right">
                                        <a href="{{ route('myplans', 'yes') }}"> <i class="fas fa-archive"></i> Go to my
                                            plans</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                        {{-- end of active investmet and purchase of investment plan --}}
                    @endif


                    {{-- 10 Recent transaction begin --}}
                    <div class="mt-4 row">
                        <div class="col-12" style="display:none">
                            <div class="nk-block-head-content">
                                <h6 class="text-primary h5">Recent transactions <span
                                        class="text-base count">({{ count($t_history) }})</span>
                                </h6>
                            </div>
                        </div>
                        <div class="col-12" style="display:none">
                            <div class="card">
                                <div class="card-body">
                                    <div class="mb-2 text-right">
                                        <a href="{{ route('accounthistory') }}"> <i class="fas fa-clipboard"></i> View
                                            all
                                            transactions</a>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr class="bg-light">
                                                    <th>Date</th>
                                                    <th>Type</th>
                                                    <th>Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($t_history as $item)
                                                    <tr>
                                                        <td>
                                                            {{ $item->created_at->toDayDateTimeString() }}
                                                        </td>
                                                        <td>
                                                            {{ $item->type }}
                                                        </td>
                                                        <td>
                                                            <span class="badge badge-secondary">
                                                                {{ $settings->currency }}{{ number_format($item->amount) }}</span>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <td colspan="3">
                                                        No record yet
                                                    </td>
                                                @endforelse

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    {{-- end of recent transactions --}}

                    <div class="mt-4 row" x-data="{
                        address: '{{ Auth::user()->ref_link }}',
                        copyToClipboard(text) {
                            if (!navigator.clipboard) {
                                return alert('Copying to clipboard only works on secure sites viewed through a modern browser.')
                            }
                            navigator.clipboard.writeText(text)
                                .then(() => {
                                    alert('Copied');
                                })
                        },
                    }">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="text-black">Refer Us & Earn</h5>
                                    <p>Use the below link to invite your friends.</p>
                                    <div class="mb-3 input-group">
                                        <input type="text" class="form-control myInput readonly"
                                            value="{{ Auth::user()->ref_link }}" id="key-02" readonly>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-primary" type="button"
                                                x-on:click="copyToClipboard(address)" data-clipboard-target="#key-02">
                                                <i class="fas fa-copy"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
    .card-header {
        padding: 0px !important;
        margin-bottom: 0;
    }
    .card-title {
      margin-bottom: 0;
    }
    .offer-popup {
    position: fixed;
    bottom: 30px;
    right: 30px;
    background: rgba(0, 0, 0, 0.9);
    color: #FFD700; /* gold text */
    border-radius: 15px;
    padding: 15px 25px;
    box-shadow: 0 0 15px rgba(255, 215, 0, 0.5);
    font-weight: 600;
    font-size: 16px;
    max-width: 280px;
    z-index: 9999;
    animation: fadeInUp 1s ease, blinkGlow 2s infinite alternate;
    transition: all 0.4s ease;
}

/* Close button styling */
.offer-popup .close {
    color: #FFD700;
    opacity: 0.8;
    font-size: 22px;
    font-weight: bold;
    position: absolute;
    top: 5px;
    right: 10px;
}

.offer-popup .close:hover {
    opacity: 1;
}

/* Blinking gold glow */
@keyframes blinkGlow {
    0% { box-shadow: 0 0 10px rgba(255, 215, 0, 0.5); }
    100% { box-shadow: 0 0 25px rgba(255, 215, 0, 1); }
}

/* Slide-up entrance animation */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.offer-text {
    background: #d68106;
    color: #fff;
    padding: 6px 14px;
    border-radius: 18px;
    font-size: 14px;
    margin-left: 6px;
    animation: pulseText 1.5s infinite;
}
/* .text-warning {
    color: #d6940d !important;
}
.bg-dark {
    background-color: #000000eb !important;
} */
/* Subtle blinking text effect */
@keyframes pulseText {
    0% { opacity: 1; }
    50% { opacity: 0.5; }
    100% { opacity: 1; }
}
</style>
@endsection
