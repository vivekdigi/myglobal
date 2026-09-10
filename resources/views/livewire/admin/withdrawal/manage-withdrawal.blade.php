<div>
    <div class="mt-2 mb-4">
        <h1 class="title1 ">Manage clients withdrawals</h1>
    </div>
    <x-admin.alert />
    <div class="mb-5 row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if ($withdrawals->count() > 0)
                        <div class="d-lg-flex mb-3">
                            <div>
                                <label for="">search</label>
                                <input type="text" class="form-control" placeholder="Search" wire:model='search'>
                            </div>
                            &nbsp; &nbsp;
                            <div class="d-flex">
                                <div>
                                    <label for="">status</label>
                                    <select class="form-control" wire:model='status'>
                                        <option>All</option>
                                        <option>Processed</option>
                                        <option>Pending</option>
                                    </select>
                                </div>
                                &nbsp; &nbsp;
                                <div>
                                    <label for="">page</label>
                                    <select class="form-control" wire:model='perPage'>
                                        <option>10</option>
                                        <option>20</option>
                                    </select>
                                </div>
                                &nbsp; &nbsp;
                                <div>
                                    <label for="">order</label>
                                    <select class="form-control" wire:model='order'>
                                        <option value="desc">Descending</option>
                                        <option value="asc">Ascending</option>
                                    </select>
                                </div>
                                &nbsp; &nbsp;
                            </div>
                            <div class="d-none d-lg-flex">
                                <div>
                                    <label for="">from</label>
                                    <input type="date" wire:model="fromDate" class="form-control" id="">
                                </div>
                                &nbsp; &nbsp;
                                <div>
                                    <label for="">to</label>
                                    <input type="date" wire:model="toDate" class="form-control" id="">
                                </div>
                                @if ($fromDate != '' && $toDate != '')
                                    <div class="d-none d-lg-flex">
                                        <div>
                                            <button class="btn btn-sm btn-primary" wire:click='resetFilter'>reset
                                                date</button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <hr>
                        <div class="table-responsive">
                            <table class="table table-hover ">
                                <thead>
                                    <tr>
                                        <th>Client name</th>
                                        <th>Amount requested</th>
                                        <th>Amount + charges</th>
                                        <th>Payment Method</th>
                                        <th>Account Id</th>
                                        <th>Email id</th>
                                        <th>Status</th>
                                        <th>Date created</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($withdrawals as $item)
                                        <tr>
                                            <td>
                                                <a class=" text-underline text-info"
                                                    href="{{ route('viewuser', ['id' => $item->duser->id]) }}">{{ $item->duser->name }}
                                                </a>
                                            </td>
                                            <td>{{ $settings->currency }}{{ number_format($item->amount) }}
                                            </td>
                                            <td>{{ $settings->currency }}{{ number_format($item->to_deduct) }}
                                            </td>
                                            <td>{{ $item->payment_mode }}</td>
                                            <td>{{ $item->duser->accountid }}</td>
                                            <td>{{ $item->duser->email }}</td>  
                                            <td>
                                                @if ($item->status == 'Processed')
                                                    <span class="badge badge-success">{{ $item->status }}</span>
                                                @else
                                                    <span class="badge badge-danger">{{ $item->status }}</span>
                                                @endif
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($item->created_at)->toDayDateTimeString() }}
                                            </td>
                                            <td>
                                                <a href="{{ route('processwithdraw', $item->id) }}"
                                                    class="m-1 btn btn-info btn-sm">
                                                    <i class="fa fa-eye"></i> View
                                                </a>
                                                <button wire:click="deleteId({{ $item->id }})" data-toggle="modal"
                                                    data-target="#exampleModal" class="m-1 btn btn-danger btn-sm">
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <!-- Modal -->
                            <div wire:ignore.self class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                            <h4>Are you sure want to delete?</h4>
                                            <div class="float-right text-right">
                                                <button type="button" class="btn btn-secondary close-btn"
                                                    data-dismiss="modal">Close</button>
                                                <button type="button" wire:click.prevent="delete()"
                                                    class="btn btn-danger close-modal" data-dismiss="modal">Yes,
                                                    Delete</button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{ $withdrawals->links() }}
                        </div>
                        <div class="d-flex d-lg-none">
                            <div>
                                <label for="">from</label>
                                <input type="date" wire:model="fromDate" class="form-control">
                            </div>
                            &nbsp; &nbsp;
                            <div>
                                <label for="">to</label>
                                <input type="date" wire:model="toDate" class="form-control">
                            </div>
                            @if ($fromDate != '' && $toDate != '')
                                <div class="d-block d-lg-none">
                                    <div>
                                        <button class="btn btn-sm btn-primary" wire:click='resetFilter'>reset
                                            date</button>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="text-center py-5">
                            <img src="{{ asset('dash/images/cloud-database-svgrepo-com.svg') }}" alt="no record found"
                                class="img-fluid">

                            @if ($search != '' || $status != 'All' || ($fromDate != '' && $toDate != ''))
                                <h1 class="mt-3 font-weight-bolder text-info">No Result found</h1>
                                <p>We couldn't find what you are looking for. Try again.</p>
                                <button type="button" class="btn btn-primary" wire:click='resetFilter'>
                                    Try again
                                </button>
                            @else
                                <h1 class="mt-3 font-weight-bolder text-info">No Data found</h1>
                                <p>
                                    You do not have any withdrawal record. <br> When your users place a
                                    withdrawal request, it will appear here.
                                </p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
