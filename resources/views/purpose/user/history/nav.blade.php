@php
    $deposits = $deposits ?? null;
    $withdrawals = $withdrawals ?? null;
    $others = $others ?? null;
    $profits = $profits ?? null;
@endphp
<div>
    <!-- Title -->
    <h1 class="h2 m-0">
        Account transactions history
    </h1>
    <p class="m-0">All your transaction history in one place.</p>
</div>

<div class="row mt-5">
    <div class="col-6 col-lg-3">
        <!-- Card -->
        <a href="{{ route('accounthistory') }}">
            <div @class([
                'card border-0',
                'bg-primary text-white' => request()->routeIs('accounthistory'),
            ])>
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex flex-column">
                            <h3 class="card-title h4 mb-0">Deposits</h3>
                            @if ($deposits)
                                <span class="fs-6 text-dark">{{ $deposits->count() }} records</span>
                            @endif
                        </div>

                        <div class="avatar avatar-circle avatar-xs me-2">
                            <i class="bi bi-wallet-fill fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-6 col-lg-3">
        <!-- Card -->
        <a href="{{ route('withdrawlhistory') }}">
            <div @class([
                'card border-0',
                'bg-primary text-white' => request()->routeIs('withdrawlhistory'),
            ])>
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex flex-column">
                            <h3 class="card-title h4 mb-0">Withdrawals</h3>
                            @if ($withdrawals)
                                <span class="fs-6 text-dark">{{ $withdrawals->count() }} records</span>
                            @endif
                        </div>

                        <div class="avatar avatar-circle avatar-xs me-2">
                            <i class="bi bi-graph-down fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    @if ($mod['investment'])
        <div class="col-6 col-lg-3">
            <!-- Card -->
            <a href="{{ route('profithistory') }}">
                <div @class([
                    'card border-0',
                    'bg-primary text-white' => request()->routeIs('profithistory'),
                ])>
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex flex-column">
                                <h3 class="card-title h4 mb-0">Profit</h3>
                                @if ($profits)
                                    <span class="fs-6 text-dark">{{ $profits->count() }} records</span>
                                @endif
                            </div>

                            <div class="avatar avatar-circle avatar-xs me-2">
                                <i class="bi bi-coin fs-3"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    @endif
    <div class="col-6 col-lg-3">
        <!-- Card -->
        <a href="{{ route('otherhistory') }}">
            <div @class([
                'card border-0',
                'bg-primary text-white' => request()->routeIs('otherhistory'),
            ])>
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex flex-column">
                            <h3 class="card-title h4 mb-0">Others</h3>
                            @if ($others)
                                <span class="fs-6 text-dark">{{ $others->count() }} records</span>
                            @endif
                        </div>

                        <div class="avatar avatar-circle avatar-xs me-2">
                            <i class="bi bi-hourglass fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>

</div>
