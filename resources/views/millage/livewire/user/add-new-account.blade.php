<div>
    <!-- Card -->
    <div class="card border-0">
        <div class="card-body">
            <h4 class="mb-3">Add new account</h4>
            <form wire:submit.prevent='addAccount'>
                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label>Duration</label>
                        <select class="form-select mt-1" wire:model="duration" wire:change='setAmount' class="duration"
                            required>
                            <option>Select duration</option>
                            <option>Monthly</option>
                            <option>Quarterly</option>
                            <option>Yearly</option>
                        </select>
                        @if ($errorMessage)
                            <small class="text-danger fs-6">{{ $errorMessage }}</small>
                        @endif
                    </div>
                    <div class="mb-3 col-md-6">
                        <label>Amount</label>
                        <input class="form-control mt-1" type="text" wire:model="amount" readonly>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label>Metatrader Type</label>
                        <select class="form-select mt-1" wire:model.defer="metatrader">
                            <option>MT4</option>
                            <option>MT5</option>
                        </select>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label>Login*:</label>
                        <input class="form-control mt-1" type="text" wire:model.defer="login" required>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label>Account Password</label>
                        <input class="form-control mt-1" type="text" wire:model.defer="password" required>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label>Account Name</label>
                        <input class="form-control mt-1" type="text" wire:model.defer="name" required>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label>Account Type</label>
                        <input class="form-control mt-1" Placeholder="E.g. Standard" type="text"
                            wire:model.defer="acnType" required>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label>Currency</label>
                        <input class="form-control mt-1" Placeholder="E.g. USD" type="text"
                            wire:model.defer="currency" required>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label>Leverage</label>
                        <input class="form-control mt-1" Placeholder="E.g. 1:500" type="text"
                            wire:model.defer="leverage" required>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label>Server</label>
                        <input class="form-control mt-1" Placeholder="E.g. HantecGlobal-live" type="text"
                            wire:model.defer="server" required>
                    </div>
                    <h6>Amount will be deducted from your account balance.</h6>
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">
                            <div class="spinner-border spinner-border-sm" wire:loading wire:target='addAccount'
                                role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            Add account
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
