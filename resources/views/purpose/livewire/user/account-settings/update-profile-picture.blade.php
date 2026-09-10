<div>
    <form wire:submit.prevent='update'>
        <label class="d-block cursor-pointer">
            <span
                class="position-absolute bottom-0 end-0 m-0 text-bg-primary w-30px h-30px rounded-circle d-flex align-items-center justify-content-center">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" height="14" width="14">
                    <g>
                        <path
                            d="M2.65,16.4a.5.5,0,0,0-.49-.13.52.52,0,0,0-.35.38L.39,23a.51.51,0,0,0,.6.6l6.36-1.42a.52.52,0,0,0,.38-.35.5.5,0,0,0-.13-.49Z"
                            style="fill: currentColor" />
                        <path
                            d="M17.85,7.21l-11,11a.24.24,0,0,0,0,.35l1.77,1.77a.5.5,0,0,0,.71,0L20,9.68A.48.48,0,0,0,20,9L18.21,7.21A.25.25,0,0,0,17.85,7.21Z"
                            style="fill: currentColor" />
                        <path
                            d="M16.79,5.79,15,4a.48.48,0,0,0-.7,0L3.71,14.63a.51.51,0,0,0,0,.71l1.77,1.77a.24.24,0,0,0,.35,0l11-11A.25.25,0,0,0,16.79,5.79Z"
                            style="fill: currentColor" />
                        <path
                            d="M22.45,1.55a4,4,0,0,0-5.66,0l-.71.71a.51.51,0,0,0,0,.71l5,4.95a.52.52,0,0,0,.71,0l.71-.71A4,4,0,0,0,22.45,1.55Z"
                            style="fill: currentColor" />
                    </g>
                </svg>
            </span>
            <input type="file" wire:model='photo' class="d-none">
        </label>
        @if ($photoPath)
            <img src="{{ asset('storage/' . $photoPath) }}" alt="Profile picture" class="avatar-img" width="112"
                height="112">
        @else
            <img src="https://png.pngtree.com/png-vector/20220521/ourlarge/pngtree-avatar-profile-icon-png-image_4644647.png"
                alt="Profile picture" class="avatar-img" width="112" height="112">
        @endif
        @if ($photo)
            <button type="submit" class="btn btn-sm btn-primary">
                <div class="spinner-border spinner-border-sm" role="status" wire:loading wire:target='update'>
                    <span class="visually-hidden">Loading...</span>
                </div>
                <span wire:loading.remove wire:target='update'>
                    Save
                </span>
            </button>
        @endif
        @error('photo')
            <small class="fs-6 text-danger">
                {{ $message }}
            </small>
        @enderror
    </form>
</div>
