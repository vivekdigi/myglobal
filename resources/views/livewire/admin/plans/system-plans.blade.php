<div>
    <div class="mt-2 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <x-page-title>
                Investment Plans
            </x-page-title>
            <div>
                <a class="btn btn-primary" href="{{ route('newplan') }}">
                    <i class="fa fa-plus"></i> New plan
                </a>
            </div>
        </div>
    </div>
    <x-admin.alert />
    <div class="mb-5 row">
        @if (!session('removeInfo'))
            <div class="col-12">
                <div class="alert alert-info">
                    <i class="fas fa-exclamation-triangle"></i>
                    Users cannot invest in an inactive plan.
                    Plan status is useful when you want to display to your users a plan but you do not
                    want them to invest in it at the moment. Users already subscribed to an inactive plan
                    would still receive ROI till the plan expires, but will not be able to purchase it.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"
                        wire:click='removeInfoSession'>
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        @endif

        @forelse ($plans as $plan)
            <div class="col-lg-4">
                <div class="pricing-table purple border card">
                    <div class="card-body">
                        <div class="text-center">
                            <div>
                                <span @class([
                                    'badge',
                                    'badge-danger' => $plan->status == 'inactive',
                                    'badge-success' => $plan->status == 'active',
                                ])>{{ $plan->status }}</span>
                            </div>

                            <h2 class="">{{ $plan->name }}</h2>
                        </div>
                        <!-- Price -->
                        <div class="price-tag">
                            <span class="symbol ">{{ $settings->currency }}</span>
                            <span class="amount ">{{ number_format($plan->price) }}</span>
                        </div>
                        <!-- Features -->
                        <div class="pricing-features">
                            <div class="feature text-dark">Minimum Possible Deposit:<span
                                    class="">{{ $settings->currency }}{{ number_format($plan->min_price) }}</span>
                            </div>
                            <div class="feature text-dark">Maximum Possible Deposit:<span
                                    class="">{{ $settings->currency }}{{ number_format($plan->max_price) }}</span>
                            </div>
                            <div class="feature text-dark">Minimum Return:<span
                                    class="">{{ number_format($plan->minr) }}%</span></div>
                            <div class="feature text-dark">Maximum Return:<span
                                    class="">{{ number_format($plan->maxr) }}%</span></div>
                            <div class="feature text-dark">Gift Bonus:<span
                                    class="">{{ $settings->currency }}{{ $plan->gift }}</span></div>
                            <div class="feature text-dark">Duration:<span class="">{{ $plan->expiration }}</span>
                            </div>
                        </div> <br>

                        <!-- Button -->
                        <div class="text-center">
                            <a href="{{ route('editplan', $plan->id) }}" class="btn btn-primary btn-sm"><i
                                    class="text-white flaticon-pencil"></i>
                            </a> &nbsp;
                            <a href="#" wire:click="deleteId({{ $plan->id }})" class="btn btn-danger btn-sm"
                                data-toggle="modal" data-target="#deleteModal">
                                <i class="text-white fa fa-times"></i>
                            </a>
                            @if ($plan->status == 'inactive')
                                <button class="btn btn-success btn-sm"
                                    wire:click="markPlanAs({{ $plan->id }}, 'active')">
                                    Mark as active
                                </button>
                            @else
                                <button class="btn btn-warning btn-sm"
                                    wire:click="markPlanAs({{ $plan->id }}, 'inactive')">
                                    Mark as inactive
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-lg-12 text-center">
                <div class="pricing-table card purple border p-4">
                    <h4 class="">No Investment Plan at the moment, click the button above to add a plan.
                    </h4>
                </div>
            </div>
        @endforelse

        <!-- Modal -->
        <div wire:ignore.self class="modal fade" id="deleteModal" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirm Delete</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true close-btn">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h4>Are you sure want to delete this plan?</h4>
                        <p>If a user have bought this plan, it will also be deleted.</p>
                        <div class="float-right text-right">
                            <button type="button" class="btn btn-secondary close-btn"
                                data-dismiss="modal">Close</button>
                            <button type="button" wire:click.prevent="deletePlan()" class="btn btn-danger close-modal"
                                data-dismiss="modal">Yes,
                                Delete</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
