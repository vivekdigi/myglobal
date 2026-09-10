<div>
    <x-danger-alert />
    <x-success-alert />
    <div class="container-fluid">
        <div class="d-flex align-items-baseline justify-content-between">
            <!-- Title -->
            <h1 class="h2 d-flex align-items-center justify-content-between">
                <span>
                    My plans
                    @if ($plans->count() > 0)
                        <a href="{{ route('mplans') }}" class="btn btn-sm btn-primary ms-4">Buy new plan</a>
                    @endif
                </span>
            </h1>
            <div class="m-0">
                <label class="form-label">Sort</label>
                <select class="form-select" wire:model='sortValue'>
                    <option>All</option>
                    <option>Active</option>
                    <option>Inactive</option>
                    <option>Expired</option>
                </select>
            </div>
        </div>

        <div class="row mt-5">
            @forelse ($plans as $plan)
                <div class="col-lg-4 mb-3">
                    <!-- Card -->
                    <div class="card border-0 mb-2 cursor-move">

                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                @if ($plan->active == 'yes')
                                    <span class="badge bg-success">Active</span>
                                @elseif($plan->active == 'expired')
                                    <span class="badge bg-danger">Expired</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                                <!-- Dropdown -->
                                <div data-bs-toggle="tooltip" title="Plan details">
                                    <a class="dropdown-item" href="{{ route('plandetails', $plan->id) }}">View</a>
                                </div>
                            </div>

                            <!-- Title -->
                            <a href="" class="h4 text-body card-title d-inline-block">
                                {{ $plan->dplan->name }}
                            </a>
                            <div class="d-flex justify-content-around">
                                <div class="mr-3 mb-0">
                                    <h6 class="text-black m-0">
                                        {{ $plan->created_at->addHour()->toDayDateTimeString() }}
                                    </h6>
                                    <span>Start Date</span>
                                </div>
                                <i class="fas fa-arrow-right text-muted"></i>
                                <div class="ml-3">
                                    <h6 class="text-black m-0">
                                        {{ \Carbon\Carbon::parse($plan->expire_date)->addHour()->toDayDateTimeString() }}
                                    </h6>
                                    <span>End Date</span>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer border-0">
                            <div class="row justify-content-between align-items-center">
                                <div class="col">
                                    <i class="bi bi-coin fs-3"></i>
                                    <span class="fs-3 h4" data-bs-toggle="tooltip"
                                        title="Amount invested">{{ $settings->currency }}{{ number_format($plan->amount) }}</span>
                                </div>
                            </div> <!-- / .row -->
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-md-12">
                    <div class="card">
                        @if (!$sortValue)
                            <div class="text-center card-body">
                                <i class="bi bi-database-fill-exclamation" style="font-size: 50px"></i>
                                <p class="h3">
                                    You do not have an investment plan at the moment
                                </p>
                                <a href="{{ route('mplans') }}" class="px-3 btn btn-primary">Buy a plan</a>
                            </div>
                        @endif
                        @if ($sortValue)
                            <div class="text-center card-body">
                                <i class="bi bi-database-fill-exclamation" style="font-size: 50px"></i>
                                <p class="h3">
                                    No record found
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            @endforelse
        </div>
        @if (count($plans) > 0)
            <div class="row">
                <div class="mt-2 col-12">
                    {{ $plans->links() }}
                </div>
            </div>
        @endif
    </div>
</div>
