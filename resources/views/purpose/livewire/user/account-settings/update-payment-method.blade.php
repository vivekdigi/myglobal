<div>
    <form method="post" wire:submit.prevent='save'>
        <div class="row">
            <div class="mb-3 col-md-6">
                <label class="">Bank Name</label>
                <input type="text" wire:model.defer='bankName' class="form-control " placeholder="Enter bank name">
            </div>
            <div class="mb-3 col-md-6">
                <label class="">Account Name</label>
                <input type="text" wire:model.defer='accountName' class="form-control "
                    placeholder="Enter Account name">
            </div>
            <div class="mb-3 col-md-6">
                <label class="">Account Number</label>
                <input type="text" wire:model.defer='accountNumber' class="form-control "
                    placeholder="Enter Account Number">
            </div>
            <div class="mb-3 col-md-6">
                <label class="">Swift Code</label>
                <input type="text" wire:model.defer='swiftCode' class="form-control " placeholder="Enter Swift Code">
            </div>
            <div class="mb-3 col-md-6">
                <label class="">Bitcoin</label>
                <input type="text" wire:model.defer='btcAddress' class="form-control "
                    placeholder="Enter Bitcoin Address">
                <small class="fs-6">Enter your Bitcoin Address that will be used to withdraw your funds</small>
            </div>
            <div class="mb-3 col-md-6">
                <label class="">Ethereum</label>
                <input type="text" wire:model.defer='ethAddress' class="form-control "
                    placeholder="Enter Etherium Address">
                <small class="fs-6">Enter your Ethereum Address that will be used to withdraw your funds</small>
            </div>

            <div class="mb-3 col-md-6">
                <label class="">Litecoin</label>
                <input type="text" wire:model.defer='ltcAddress' class="form-control "
                    placeholder="Enter Litcoin Address">
                <small class="fs-6">Enter your Litecoin Address that will be used to withdraw your funds</small>
            </div>

            <div class="mb-3 col-md-6">
                <label>USDT.TRC20</label>
                <input type="text" wire:model.defer='usdtAddress' class="form-control"
                    placeholder="Enter USDT.TRC20 Address">
                <small class="fs-6">Enter your USDT.TRC20 wallet Address that will be used to withdraw your
                    funds</small>
            </div>
        </div>
        <div class="d-flex justify-content-end mt-5">
            <button type="submit" class="btn btn-primary">
                <div class="spinner-border spinner-border-sm" role="status" wire:loading>
                    <span class="visually-hidden">Loading...</span>
                </div>
                Save changes
            </button>
        </div>
    </form>
</div>
