<div>
    <div class="page-inner">
        <x-admin.alert />
        <div class="row my-3">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Payment Settings</h5>
                        {{-- <p class="card-text">You can set the subscription fee type here.</p>
                        <div class="mt-1">
                            <div class="selectgroup">
                                <label class="selectgroup-item">
                                    <input type="radio" class="selectgroup-input" name="subtype"
                                        {{ $subType == 'Fixed' ? 'checked' : '' }} wire:click="changeSubType('Fixed')">
                                    <span class="selectgroup-button">Fixed Amount</span>
                                </label>
                                <label class="selectgroup-item">
                                    <input type="radio" class="selectgroup-input" name="subtype"
                                        {{ $subType == 'Percentage' ? 'checked' : '' }}
                                        wire:click="changeSubType('Percentage')">
                                    <span class="selectgroup-button">Commission (percentage share)</span>
                                </label>
                            </div>
                            <div class="mt-2">
                                <small>{{ $subInfo }}</small>
                            </div>
                        </div> --}}
                        <div class="mt-3">
                            @if ($subType == 'Fixed')
                                <form method="post" wire:submit.prevent='saveFixed'>
                                    <div class="form-group">
                                        <label>Monthly Subscription Fee ({{ $settings->currency }}):</label>
                                        <input type="number" step="any" wire:model.defer='monthlyFee'
                                            class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label>Quaterly Subscription Fee ({{ $settings->currency }}):</label>
                                        <input type="number" step="any" wire:model.defer="quarterlyFee"
                                            class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label>Yearly Subscription Fee ({{ $settings->currency }}):</label>
                                        <input type="number" step="any" wire:model.defer="yearlyFee"
                                            class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <input type="submit" class="px-5 btn btn-primary btn-lg" value="Save">
                                        <input type="hidden" name="id" value="1">
                                    </div>
                                </form>
                            @endif
                            @if ($subType == 'Percentage')
                                <div>
                                    <div class="text-center">
                                        <h4>You will need to set the commission for individual Master(Provider) account.
                                        </h4>
                                        <a href="{{ route('tsettings') }}" class="btn btn-sm btn-primary">Setup
                                            commission</a>
                                    </div>
                                    {{-- <div class="mt-3">
                                    <label for="">Conenction Fee</label>
                                    <input type="number" wire:model.lazy='conectionFee' step="any"
                                        class="form-control" style="max-width: 60%">
                                    <small class="d-block">Click outside after typing to save.</small>
                                    @error('conectionFee')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                    @if (session('status'))
                                        <small class="text-success">{{ session('status') }}</small>
                                    @endif
                                </div> --}}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-3 row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-body">
                        {{-- <div class="text-center" wire:loading wire:target='changeSubType'>
                            <div class="spinner-border" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div> --}}
                        <h5 class="card-title">Other Settings</h5>
                        <div class="mt-3">
                            <form action="" wire:submit.prevent='saveIbLink'>
                                <div class="form-group">
                                    <label>IB Link</label>
                                    <input type="text" wire:model.defer="iblink" class="form-control" required>
                                    <small>
                                        IB Link allows you to set a link for your IB account. This link will be used to
                                        redirect your clients to your IB account if they want to open a new account.
                                    </small>
                                </div>

                                <div class="form-group">
                                    <input type="submit" class="px-5 btn btn-primary btn-lg" value="Save">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
