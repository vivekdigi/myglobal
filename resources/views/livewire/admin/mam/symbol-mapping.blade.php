<div>
    <div class="mt-2 mb-4 d-flex justify-content-between align-items-center">
        <h1 class="title1">Map Symbols</h1>
        <div>
            <button class="btn btn-primary btn-sm" wire:click="$set('addSymbol', true)">Add Symbol</button>
        </div>
    </div>
    <x-admin.alert />
    <div class="row">
        @if ($addSymbol)
            <div class="col-12">
                <div class="card">
                    <div class="row">
                        <div class="col-lg-6 offset-lg-3 py-4">
                            <h4>Add New Symbol map</h4>
                            <form action="" wire:submit.prevent='addSymbolMapping'>
                                <div class="form-group">
                                    <label for="">Map Symbol From</label>
                                    <input type="text" placeholder="eg EURUSD.m" class="form-control"
                                        wire:model.defer='from'>
                                </div>
                                <div class="form-group">
                                    <label for="">Map Symbol To</label>
                                    <input type="text" placeholder="eg EURUSD" class="form-control"
                                        wire:model.defer='to'>
                                </div>
                                <div class="form-group">
                                    <button type="button" wire:click="$set('addSymbol', false)"
                                        class="btn btn-warning btn-sm">Cancel</button>
                                    <button type="submit" class="btn btn-primary btn-sm">Add Symbol</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if (!$addSymbol)
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                                <th>Symbol From</th>
                                <th>Symbol To</th>
                                <th></th>
                            </thead>
                            <tbody>
                                @forelse ($symbols as $symbol)
                                    <tr>
                                        <td>{{ $symbol->from_symbol }}</td>
                                        <td>{{ $symbol->to_symbol }}</td>
                                        <td>
                                            <button class="btn btn-danger btn-sm"
                                                wire:click="deleteSymbolMapping({{ $symbol->id }})">Delete</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">No symbols maps defined</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
