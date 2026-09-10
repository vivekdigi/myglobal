<div>
    <form action="" method="post" wire:submit.prevent='saveSettings'>
        <div class="form-row">
            <div class="col-lg-6 mb-4">
                <label for="">App Enviroment</label>
                <select class="form-control" wire:model='enviroment'>
                    <option>local</option>
                    <option>staging</option>
                    <option>production</option>
                </select>
            </div>
            <div class="col-lg-6 mb-4 text-center">
                <label for="">Debug Mode</label>
                <div class="custom-control custom-switch">
                    <input type="checkbox" wire:model='appDebug' class="custom-control-input" id="customSwitch1">
                    <label class="custom-control-label" for="customSwitch1"></label>
                </div>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Save</button>
                @if (session()->has('success-message'))
                    <small class="text-success d-block mt-2"> {{ session('success-message') }}</small>
                @endif
            </div>
        </div>
    </form>
</div>
