<div>
    <form action="" method="post" wire:submit.prevent='saveTheme'>
        <div class="form-group">
            <label>Current user dashboard theme</label>
            <select class="form-control" wire:model='theme'>
                @foreach ($themes as $item)
                    <option>
                        {{ $item }}
                    </option>
                @endforeach
            </select>
            <small class="text-success">{{ $sucMsg }}</small>
        </div>
        <div class="form-group">
            <button type="submit" class="px-4 btn btn-primary btn-sm">Save</button>
        </div>
    </form>
    {{-- <button wire:click='addNewTheme'>add theme</button> --}}
</div>
