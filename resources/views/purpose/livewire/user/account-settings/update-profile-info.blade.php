<div>
    <form action="" wire:submit.prevent='updateProfileInfo'>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-lg-3">
                    <label for="fullName" class="col-form-label">Full Name</label>
                </div>

                <div class="col-lg">
                    <input type="text" class="form-control" id="fullName" wire:model.defer='name' required>
                    <div class="invalid-feedback">Please add your full name</div>
                </div>
            </div> <!-- / .row -->

            <div class="row mb-4">
                <div class="col-lg-3">
                    <label for="phone" class="col-form-label">Phone</label>
                </div>

                <div class="col-lg">
                    <input type="text" class="form-control" id="phone" wire:model.defer='phone' required>
                    @error('phone')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div> <!-- / .row -->

            <div class="row mb-4">
                <div class="col-lg-3">
                    <label for="emailAddress" class="col-form-label">Email address</label>
                </div>

                <div class="col-lg">
                    <input type="text" class="form-control" id="emailAddress" wire:model='email' readonly>
                    <div class="invalid-feedback">Please add your email address</div>
                </div>
            </div> <!-- / .row -->

            <div class="row mb-4">
                <div class="col-lg-3">
                    <label for="country" class="col-form-label">Country</label>
                </div>

                <div class="col-lg">
                    <div class="mb-4">
                        <select class="form-select" required wire:model.defer='country'>
                            @include('auth.countries')
                        </select>
                        <div class="invalid-feedback">Please select a country</div>
                    </div>
                </div>
            </div> <!-- / .row -->
            <div class="row mb-4">
                <div class="col-lg-3">
                    <label class="col-form-label">Username</label>
                </div>
                <div class="col-lg">
                    <input type="text" class="form-control" wire:model='username' readonly>
                </div>
            </div> <!-- / .row -->
            <div class="d-flex justify-content-end mt-5">
                <button type="submit" class="btn btn-primary">
                    <div class="spinner-border spinner-border-sm" role="status" wire:loading>
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    Save changes
                </button>
            </div>
        </div>
    </form>

</div>
