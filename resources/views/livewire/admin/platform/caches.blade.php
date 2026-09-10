<div>
    <div class="text-right">
        <button class="btn btn-warning btn-sm" wire:click='clearCache'>Clear all cache</button>
    </div>
    {{-- <h5>Make your site respond faster.</h5> --}}
    <table class="table table-light">
        <thead>
            <tr>
                <th>Cache</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    Clear compiled views to make views up to date.
                </td>
                <td>
                    @if ($viewCached)
                        <button class="btn btn-warning btn-sm" wire:click='clearCompiledViews'>Clear view cache</button>
                    @else
                        <button class="btn btn-primary btn-sm" wire:click='cacheViews'>Cache Views</button>
                    @endif
                </td>
            </tr>
            <tr>
                <td>
                    Clear and cache your routes.
                </td>
                <td>
                    @if ($routeCached)
                        <button class="btn btn-warning btn-sm" wire:click='clearRouteCache'>Clear route cache</button>
                    @else
                        <button class="btn btn-primary btn-sm" wire:click='cacheRoutes'>Cache Routes</button>
                    @endif
                </td>
            </tr>
            <tr>
                <td>
                    Clear and cache config.
                </td>
                <td>
                    @if ($configCached)
                        <button class="btn btn-warning btn-sm" wire:click='clearConfigCache'>Clear config cache</button>
                    @else
                        <button class="btn btn-primary btn-sm" wire:click='cacheConfig'>Cache Config</button>
                    @endif
                </td>
            </tr>
        </tbody>
    </table>
</div>
