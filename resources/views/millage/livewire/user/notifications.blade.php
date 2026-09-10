<div>
    @forelse ($notifications as $item)
        <div class="list-group-item list-group-item-action {{ !$item->read_at ? 'bg-light' : '' }}">
            <div class="d-flex flex-column flex-grow-1">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1"></h5>
                    <small class="text-muted">{{ $item->created_at->diffForHumans() }}</small>
                </div>
                <div class="d-flex flex-column">
                    <p class="mb-1">{{ $item->data['title'] }}</p>
                    <small class="text-secondary">{{ $item->data['message'] }}</small>
                </div>
            </div>
            <div class="d-flex justify-content-end align-items-center">
                @if (!$item->read_at)
                    <div>
                        <a href="" wire:click.prevent="markAsRead('{{ $item->id }}')" data-bs-toggle="tooltip"
                            data-bs-placement="top" data-bs-title="Mark as read">
                            <i class="bi bi-eye fs-3"></i>
                        </a>
                    </div>
                    &nbsp; &nbsp;
                @endif
                <div>
                    <a href="" wire:click.prevent="deleteNotification('{{ $item->id }}')"
                        data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete notification">
                        <i class="bi bi-trash fs-3 text-danger"></i>
                    </a>
                </div>
            </div>
        </div>
        @if ($loop->last)
            <div class="text-center p-3">
                <a href="" wire:click.prevent="markAllAsRead" data-bs-toggle="tooltip" data-bs-placement="top"
                    data-bs-title="Mark all as read">
                    <i class="bi bi-eye fs-3"></i>
                    Mark all as read
                </a>
            </div>
        @endif
    @empty
        <div class="text-center py-5 mt-5">
            <i class="bi bi-bell-slash fs-1 text-secondary"></i>
            <p class="text-secondary">There are no new notifications</p>
        </div>
    @endforelse
</div>
