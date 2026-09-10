<div>
    <x-admin.alert />
    <div class="mt-2 mb-4 d-flex justify-content-between align-items-center">
        <h1 class="title1 ">Trade Signals</h1>
        <div>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary btn-sm px-3" wire:click='newSignal'>
                Add Signal
            </button>
        </div>
    </div>

    <div class="mb-5 row">
        @if ($newSignal)
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-8 offset-lg-2">
                                <form wire:submit.prevent='addSignal'>
                                    <div class="row">
                                        <div class="col-md-6 mt-3">
                                            <label for="">Order type</label>
                                            <select wire:model.defer="tradeDirection" class=" form-control rounded-none"
                                                required>
                                                <option value="Sell">Sell</option>
                                                <option value="Buy">Buy</option>
                                                <option value="Buy-Stop">Buy-Stop</option>
                                                <option value="Sell-Stop">Sell-Stop</option>
                                                <option value="Sell-Limit">Sell-Limit</option>
                                                <option value="Buy-Limit">Buy-Limit</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mt-3">
                                            <label for="">Currency Pair</label>
                                            <input type="text" wire:model.defer="tradePair"
                                                class="form-control rounded-non" placeholder="eg EUR/USD" required>
                                        </div>
                                        <div class="col-md-6 mt-3">
                                            <label for="">Price</label>
                                            <input type="text" wire:model.defer="price"
                                                class="form-control rounded-none" placeholder="" required>
                                        </div>
                                        <div class="col-md-6 mt-3">
                                            <label for="">Take Profit 1</label>
                                            <input type="text" step="any" wire:model.defer="takeProfit1"
                                                class="form-control rounded-none" required>
                                        </div>
                                        <div class="col-md-6 mt-3">
                                            <label for="">Take Profit 2</label>
                                            <input type="text" step="any" wire:model.defer="takeProfit2"
                                                class="form-control rounded-none">
                                        </div>
                                        <div class="col-md-6 mt-3">
                                            <label for="">Stop Loss</label>
                                            <input type="number" step="any" class="form-control rounded-none"
                                                wire:model.defer="stopLoss" required>
                                        </div>
                                        {{-- <div class="col-md-6 mt-3">
                                            <label for="">Buy Stop</label>
                                            <input type="number" step="any" class="form-control rounded-none"
                                                wire:model.defer="buyStop" required>
                                            <small>Enter "-" if not needed</small>
                                        </div>
                                        <div class="col-md-6 mt-3">
                                            <label for="">Sell Stop</label>
                                            <input type="number" step="any" class="form-control rounded-none"
                                                wire:model.defer="sellStop"required>
                                            <small>Enter "-" if not needed</small>
                                        </div> --}}
                                        {{-- <div class="col-md-6 mt-3">
                                            <label for="">Sell Limit</label>
                                            <input type="number" step="any" class="form-control rounded-none"
                                                wire:model.defer="sellLimit" required>
                                            <small>Enter "-" if not needed</small>
                                        </div>
                                        <div class="col-md-6 mt-3">
                                            <label for="">Buy Limit</label>
                                            <input type="number" step="any" class="form-control rounded-none"
                                                wire:model.defer="buyLimit" required>
                                            <small>Enter "-" if not needed</small>
                                        </div> --}}
                                        <div class="col-12 mt-3">
                                            <button class="btn btn-info btn-sm" type="button"
                                                wire:click='cancel'>Cancel</button>
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                <div class="spinner-border spinner-border-sm" role="status"
                                                    wire:loading wire:target="addSignal">
                                                    <span class="sr-only">Loading...</span>
                                                </div>
                                                Add Signal
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if (!$newSignal)
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <th>
                                        Ref
                                    </th>
                                    <th>
                                        Order type
                                    </th>
                                    <th>
                                        Currency Pair
                                    </th>
                                    <th>
                                        Price
                                    </th>
                                    <th>
                                        Take Profit-1
                                    </th>
                                    <th>
                                        Take Profit-2
                                    </th>
                                    <th>
                                        Stop Loss
                                    </th>
                                    {{-- <th>Buy Stop</th>
                                    <th>Sell Stop</th>
                                    <th>Sell Limit</th>
                                    <th>Buy Limit</th> --}}
                                    <th>
                                        Result
                                    </th>
                                    <th>
                                        Status
                                    </th>
                                    <th>
                                        Date Added
                                    </th>
                                    <th>
                                    </th>
                                </thead>
                                <tbody>
                                    @forelse ($signals as $signal)
                                        <tr>
                                            <td>#{{ $signal['reference'] }}</td>
                                            <td>
                                                @if ($signal['trade_direction'] == 'Buy')
                                                    <i class="fa fa-arrow-up text-success"></i>
                                                @else
                                                    <i class="fa fa-arrow-down text-danger"></i>
                                                @endif
                                                {{ $signal['trade_direction'] }}
                                            </td>
                                            <td>{{ $signal['currency_pair'] }}</td>
                                            <td>{{ $signal['price'] }}</td>
                                            <td>{{ $signal['take_profit1'] }}</td>
                                            <td>{{ $signal['take_profit2'] ? $signal['take_profit2'] : '-' }}</td>
                                            <td>{{ $signal['stop_loss1'] }}</td>
                                            {{-- <td>{{ $signal['buy_stop'] ? $signal['buy_stop'] : '-' }}</td>
                                            <td>{{ $signal['sell_stop'] ? $signal['sell_stop'] : '-' }}</td>
                                            <td>{{ $signal['sell_limit'] ? $signal['sell_limit'] : '-' }}</td>
                                            <td>{{ $signal['buy_limit'] ? $signal['buy_limit'] : '-' }}</td> --}}
                                            <td>{{ $signal['result'] ? $signal['result'] : '-' }}</td>
                                            <td>
                                                @if ($signal['status'] == 'published')
                                                    <span class="badge badge-success"> {{ $signal['status'] }}</span>
                                                @else
                                                    <span class="badge badge-danger"> {{ $signal['status'] }}</span>
                                                @endif
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($signal['created_at'])->addHour()->toDayDateTimeString() }}
                                            </td>
                                            <td>
                                                @if ($signal['status'] == 'unpublished')
                                                    <button type="submit" wire:click="publish({{ $signal['id'] }})"
                                                        class="btn btn-primary btn-sm" wire:loading.attr='disabled'
                                                        wire:target="publish({{ $signal['id'] }})">
                                                        <div class="spinner-border spinner-border-sm" role="status"
                                                            wire:loading wire:target="publish({{ $signal['id'] }})">
                                                            <span class="sr-only">Loading...</span>
                                                        </div>
                                                        Publish
                                                    </button>
                                                @else
                                                    <a href="#" class="btn btn-secondary btn-sm m-1"
                                                        data-toggle="modal" data-target="#resultModal"
                                                        wire:click="setSignalId({{ $signal['id'] }})">
                                                        Add Result
                                                    </a>
                                                @endif

                                                <a href="#" wire:click="setSignalId({{ $signal['id'] }})"
                                                    class="btn btn-danger btn-sm m-1" data-toggle="modal"
                                                    data-target="#exampleModal">
                                                    Delete
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="11" class="text-center">
                                                No Data Available
                                            </td>
                                        </tr>
                                    @endforelse
                                    <!-- Delete Modal -->
                                    <div wire:ignore.self class="modal fade" id="exampleModal" tabindex="-1"
                                        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Confirm Delete
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true close-btn">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <h4>Are you sure want to delete this signal?</h4>
                                                    <div class="float-right text-right">
                                                        <button type="button" class="btn btn-secondary close-btn"
                                                            data-dismiss="modal">Close</button>
                                                        <button type="button" wire:click.prevent="deleteSignal()"
                                                            class="btn btn-danger close-modal"
                                                            data-dismiss="modal">Yes,
                                                            Delete</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- End Delete Modal --}}
                                    <!-- Modal -->
                                    <div class="modal fade" id="resultModal" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">
                                                        Update Signal Result
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form wire:submit.prevent='updateResult'>
                                                        <div class="form-group">
                                                            <label>Result</label>
                                                            <input type="text" wire:model.defer='signalResult'
                                                                class="form-control" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <button type="submit" class="btn btn-primary btn-sm">
                                                                <div class="spinner-border spinner-border-sm"
                                                                    role="status" wire:loading
                                                                    wire:target='updateResult'>
                                                                    <span class="sr-only">Loading...</span>
                                                                </div>
                                                                Publish Result
                                                            </button>
                                                            <button type="button" class="btn btn-danger btn-sm"
                                                                data-dismiss="modal" aria-label="Close">
                                                                Cancel
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- End Modal --}}
                                </tbody>
                            </table>
                        </div>
                        {{-- <x-paginator :links="$signals" /> --}}
                    </div>
                </div>
            </div>
        @endif

    </div>
</div>
