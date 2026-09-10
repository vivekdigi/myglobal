<div>
    <x-admin.alert />
    <div class="mt-2 mb-4">
        <h1 class="title1 m-0">Trade Signals Settings</h1>
        <p>Set trade signal subscription fees</p>
    </div>
    <div class="mb-5 row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8 offset-lg-2">
                            <form wire:submit.prevent='saveSettings'>
                                <div class="form-group">
                                    <label for="">Monthly Fee ({{ $settings->currency }})</label>
                                    <input type="number" step="any" class="form-control"
                                        wire:model.defer='monthlyFee'>
                                </div>
                                <div class="form-group">
                                    <label for="">Quaterly Fee ({{ $settings->currency }})</label>
                                    <input type="number" step="any" wire:model.defer='quaterlyFee'
                                        class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Yearly Fee ({{ $settings->currency }})</label>
                                    <input type="number" step="any" wire:model.defer='yearlyFee'
                                        class="form-control">
                                </div>
                                <div class="form-group">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <label>Chat ID</label>
                                        @if ($chatId == '')
                                            <button class="btn btn-info btn-sm" wire:click='getChatId'
                                                wire:loading.attr='disabled' wire:target='getChatId'>
                                                <div class="spinner-border spinner-border-sm" role="status"
                                                    wire:loading wire:target="getChatId">
                                                    <span class="sr-only">Loading...</span>
                                                </div>
                                                Get ID
                                            </button>
                                        @else
                                            <button class="btn btn-danger btn-sm" wire:click='deleteChatId'
                                                wire:loading.attr='disabled' wire:target='deleteChatId'>
                                                <div class="spinner-border spinner-border-sm" role="status"
                                                    wire:loading wire:target="deleteChatId">
                                                    <span class="sr-only">Loading...</span>
                                                </div>
                                                Delete ID
                                            </button>
                                        @endif
                                    </div>
                                    <input type="text" wire:model.defer='chatId' class="form-control" readonly>
                                    @if ($chatId == '')
                                        <small>
                                            Please make sure you have entered your telegram bot api and have
                                            sent at least one message on your private channel. Also make sure
                                            you have added the bot as an admin to the private channel, in order
                                            to retrieve the chat ID.
                                        </small>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="">Telegram Bot Api</label>
                                    <input type="text" wire:model.defer='botToken' class="form-control">
                                    <p>
                                        <a href="https://core.telegram.org/bots/features#creating-a-new-bot"
                                            target="_blank" class="mt-2 text-danger">
                                            See How
                                            <i class="fa fa-link"></i>
                                        </a> to create your telegram bot
                                    </p>
                                </div>

                                <div class="form-group">
                                    <button class="btn btn-primary px-4" type="submit">
                                        <div class="spinner-border spinner-border-sm" role="status" wire:loading
                                            wire:target="saveSettings">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                        Save
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
