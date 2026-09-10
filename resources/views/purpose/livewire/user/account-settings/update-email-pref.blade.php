<div>
    <!-- Table -->
    <div class="table-responsive">
        <table id="notificationsTable" class="table align-middle">
            <thead class="thead-light">
                <tr>
                    <th class="text-uppercase py-4 align-middle min-w-300px min-w-md-auto">Type</th>
                    <th class="text-center text-uppercase py-4">
                        Yes
                    </th>
                    <th class="text-center text-uppercase py-4">
                        No
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <h3 class="h4 mb-0">Enable E-mail notification on withdrawal</h3>
                        <p class="small text-muted mb-0">Send confirmation OTP to my email when withdrawing my funds.</p>
                    </td>
                    <td class="text-center">
                        <div class="form-check form-check-inline m-0">
                            <input class="form-check-input" wire:model='emailOnWithdrawal' type="radio"
                                value="Yes">
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="form-check form-check-inline m-0">
                            <input class="form-check-input" wire:model='emailOnWithdrawal' type="radio"
                                value="No">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h3 class="h4 mb-0">Enable E-mail Notifications on Profit</h3>
                        <p class="small text-muted mb-0">Send me email when i receive profit</p>
                    </td>
                    <td class="text-center">
                        <div class="form-check form-check-inline m-0">
                            <input class="form-check-input" wire:model='emailOnRoi' type="radio" value="Yes">
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="form-check form-check-inline m-0">
                            <input class="form-check-input" wire:model='emailOnRoi' type="radio" value="No">
                        </div>
                    </td>

                </tr>
                <tr>
                    <td>
                        <h3 class="h4 mb-0">Enable E-mail Notifications on Expiration</h3>
                        <p class="small text-muted mb-0">Send me email when my investment plan expires</p>
                    </td>
                    <td class="text-center">
                        <div class="form-check form-check-inline m-0">
                            <input class="form-check-input" wire:model='emailOnExpiration' type="radio"
                                value="Yes">
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="form-check form-check-inline m-0">
                            <input class="form-check-input" wire:model='emailOnExpiration' type="radio"
                                value="No">
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div> <!-- / .table-responsive -->
    <div class="d-flex justify-content-end mt-5">
        <!-- Button -->
        <button type="button" wire:click='saveEmails' class="btn btn-primary">Save changes</button>
    </div>
</div>
