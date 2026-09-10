<div>
    <x-admin.alert />
    <div class="text-right mb-3">
        <a class="btn btn-success btn-sm"
            href="{{ route('deploymentAll', ['accounttype' => 'providers', 'deploytype' => 'deploy']) }}">
            Deploy All
        </a>
        <a class="btn btn-danger btn-sm"
            href="{{ route('deploymentAll', ['accounttype' => 'providers', 'deploytype' => 'undeploy']) }}">
            Undeploy All
        </a>

    </div>
    @include('admin.subscription.master.statistics', ['myaccount' => $account])
    <div class="mb-5 row">
        <div class="col-md-12">
            @if ($providers and count($providers) < 1)
                <div class="card">
                    <div class="card-body">
                        <div class="text-center">
                            <h5 class="card-title">No Master Trading Account</h5>
                            <p>Add a master account</p>
                            <a href="{{ route('create.master') }}" type="button" class="text-white btn btn-primary"
                                data-toggle="modal" data-target="#masterModal">
                                Add Account
                            </a>
                        </div>

                    </div>
                </div>
            @else
                <div class="card">
                    <div class="card-body">
                        <div class="text-center">
                            <p>Add a master account</p>
                            <a href="{{ route('create.master') }}" type="button" class="text-white btn btn-primary"
                                data-toggle="modal" data-target="#masterModal">
                                Add Account
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card mt-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 mb-2">
                                <h1 class=" font-weight-bold d-md-block d-none">Your Master(Provider) Accounts
                                </h1>
                                <h2 class=" font-weight-bold d-md-none d-block">Your Master(Provider) Accounts
                                </h2>
                                <p class="text-primary font-weight-bold">
                                    NOTE: Your master Account will be
                                    deleted after
                                    10 days of
                                    expiration and have not been renewed.
                                </p>
                                <div class=" table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Account ID</th>
                                                <th>Account Password</th>
                                                <th>Account Type</th>
                                                <th>Account Name</th>
                                                <th>Server</th>
                                                <th>Deployment status</th>
                                                <th>Started at</th>
                                                <th>Expiring at</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($providers as $item)
                                                <tr>
                                                    <td>
                                                        {{ $item['login'] }}
                                                    </td>
                                                    <td>
                                                        {{ $item['password'] }}
                                                    </td>
                                                    <td>
                                                        {{ $item['account_type'] }}
                                                    </td>
                                                    <td>
                                                        {{ $item['account_name'] }}
                                                    </td>
                                                    <td>
                                                        {{ $item['server'] }}
                                                    </td>
                                                    <td>
                                                        @if ($item['deployment_status'] == 'Deployed')
                                                            <h2 class="badge badge-success">
                                                                {{ $item['deployment_status'] }}</h2>
                                                        @else
                                                            <h2 class="badge badge-warning">
                                                                {{ $item['deployment_status'] }}</h2>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <span>{{ \Carbon\Carbon::parse($item['start_date'])->toDayDateTimeString() }}</span>
                                                    </td>
                                                    <td>
                                                        {{ \Carbon\Carbon::parse($item['end_date'])->toDayDateTimeString() }}
                                                    </td>
                                                    <td>
                                                        @if (now()->greaterThanOrEqualTo(\Carbon\Carbon::parse($item['end_date'])))
                                                            <a href="#" class="btn btn-info btn-sm m-1"
                                                                data-toggle="modal"
                                                                data-target="#renewModal{{ $item['id'] }}">Renew</a>
                                                        @endif

                                                        <button type="button" data-toggle="modal"
                                                            data-target="#strategyModal"
                                                            wire:click="fetchStrategy(
                                                                '{{ $item['id'] }}',
                                                                '{{ $item['strategy_name'] }}',
                                                                '{{ $item['strategy_description'] }}',
                                                                '{{ $item['strategy_mode'] }}',
                                                                '{{ $item['stra_com'] }}',
                                                                '{{ $item['commission_type'] }}',
                                                                '{{ $item['commission_rate'] }}',
                                                                '{{ $item['billing_period'] }}',
                                                                '{{ $item['bot_token'] }}',
                                                                '{{ $item['chat_id'] }}',
                                                                '{{ $item['publish_to_telegram'] }}'
                                                                )"
                                                            class="btn btn-secondary btn-sm m-1">
                                                            <span>
                                                                Update Account
                                                            </span>
                                                        </button>
                                                        <button type="button" data-toggle="modal"
                                                            data-target="#deleteModal"
                                                            wire:click="$set('acountId', '{{ $item['id'] }}')"
                                                            class="btn btn-danger btn-sm m-1">
                                                            <i class="fa fa-trash"></i>
                                                            <span> Delete</span>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="9" class="text-center">
                                                        No Data Available
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- delete modal --}}
                <div wire:ignore.self class="modal fade" id="deleteModal" tabindex="-1"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Delete Trading Account </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body text-center">
                                Are you sure you want to detele trading master account? {{ $acountId }}
                                <div class="mt-3">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                                    </button>
                                    <a href="{{ route('del.master', ['id' => $acountId]) }}" type="button"
                                        class="btn btn-danger">
                                        Yes Delete
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- end delete modal --}}
                <!-- Renew Master account Modal -->
                <div wire:ignore.self class="modal fade" id="renewModal" tabindex="-1"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Renew
                                    Master Account
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body text-center">
                                <h3>You will be charged ${{ $amountPerSlot }} for renewal.</h3>
                                <form action="{{ route('renew.master') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="account_id" value="{{ $acountId }}">
                                    <button type="submit" class="btn btn-primary">
                                        Yes Proceed
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Strategy Modal -->
                <div wire:ignore.self class="modal fade" id="strategyModal" tabindex="-1"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">
                                    Update Your strategy
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('updatestrategy') }}" method="post">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-lg-6">
                                            <label>Strategy Name</label>
                                            <input type="text" name="name" wire:model.defer='strategyName'
                                                class="form-control">
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label>Short Description</label>
                                            <input type="text" name="desc" wire:model.defer='strategyDesc'
                                                class="form-control">
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label for="">Trade Size Mode</label>
                                            <select name="trademode" id='trademode' wire:model.defer='tradeMode'
                                                class="form-control py-2" required>
                                                <option>none</option>
                                                <option>contractSize</option>
                                                <option>balance</option>
                                                <option>equity</option>
                                                <option>fixedVolume</option>
                                                <option>fixedRisk</option>
                                                <option>expression</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <textarea cols="4" id="msgbox" class="form-control" readonly>{{ $modeInfo }}</textarea>
                                        </div>
                                        <div class="form-group col-lg-6" id="optionSelected" style="display: none">
                                            <label id="optionTitle"></label>
                                            <input type="text" id="optionInput" name="modecompliment"
                                                wire:model.defer='compliment' class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-row" x-data="{ publish: @entangle('publish') }">
                                        <div class="form-group col-lg-12">
                                            <div class="pl-3">
                                                <input class="form-check-input" type="checkbox" id="defaultCheck1"
                                                    x-model="publish" name="publishsignal">
                                                <label class="form-check-label" for="defaultCheck1">
                                                    Publish trades to a Telegram channel
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-6" x-show="publish">
                                            <label>Telegram Bot Token</label>
                                            <input type="text" name="token" wire:model.defer='botToken'
                                                class="form-control">
                                        </div>
                                        <div class="form-group col-lg-6" x-show="publish">
                                            <label>Telegram Chat ID</label>
                                            <input type="text" name="chatId" wire:model.defer='chatId'
                                                class="form-control">
                                        </div>
                                        <div class="form-group col-12" x-show="publish">
                                            <small>
                                                In order to publish your strategy trades to a Telegram channel,
                                                please:
                                            </small>
                                            <ul>
                                                <li>Create telegram bot via BotFather (<a
                                                        href="https://onlinetrade.questdigiflex.in/doc/How-to-create-a-telegram-bot"
                                                        target="_blank">see this doc
                                                    </a>)</li>
                                                <li>Make your bot an administrator of the channel you are going to
                                                    publish the trades to.</li>
                                                <li>Configure your CopyFactory strategy to publish trades via Telegram
                                                    (see form above).</li>
                                            </ul>
                                        </div>
                                    </div>
                                    @if ($settings->subscription_type == 'Percentage')
                                        <hr>
                                        <h4 class="m-0 font-weight-bold">You set your subscription type to Percentage
                                            Share.</h4>
                                        <p class="m-0">Set up Provider Commission for this master account.</p>
                                        <div class="form-row">
                                            <div class="form-group col-lg-6">
                                                <label>Commission Type:</label>
                                                <select wire:model.defer='commissionType' name="commission_type"
                                                    class="form-control" required>
                                                    <option>flat-fee</option>
                                                    <option>lots-traded</option>
                                                    <option>lots-won</option>
                                                    <option>amount-traded</option>
                                                    <option>amount-won</option>
                                                    <option>high-water-mark</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <label>Billing Period:</label>
                                                <select wire:model.defer='period' name="billing_period"
                                                    class="form-control" required>
                                                    <option>week</option>
                                                    <option>month</option>
                                                    <option>quarter</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <label>Commission Rate(%):</label>
                                                <input type="number" name="percentage_fee" step="any"
                                                    class="form-control" wire:model.defer='rate' required>
                                                <small>
                                                    <span class="font-weight-bold">Should</span> be greater than or
                                                    equal
                                                    to zero if commission type is flat-fee, lots-traded or lots-won.
                                                </small>
                                                <small>
                                                    <span class="font-weight-bold">Should</span> be greater than or
                                                    equal
                                                    to zero and less than or equal to 1 if
                                                    commission type is amount-traded, amount-won, high-water-mark
                                                </small>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="form-group col-12">
                                        <input type="hidden" name="account_id" value="{{ $acountId }}">
                                        <button type="submit" class="btn btn-primary px-3">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- end update strategy --}}
            @endif
            @include('admin.subscription.master.create-master')
        </div>
    </div>
</div>
