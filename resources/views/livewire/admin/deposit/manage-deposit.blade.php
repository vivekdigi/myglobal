<div>
    <div class="mt-2 mb-4">
        <h1 class="title1 ">Manage clients deposits</h1>
    </div>
    <x-admin.alert />
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if ($deposits->count() > 0)
                        <div class="d-lg-flex mb-3">
                            <div>
                                <label for="">search</label>
                                <input type="text" class="form-control" placeholder="Search by user name"
                                    wire:model='search'>
                            </div>
                            &nbsp; &nbsp;
                            <div class="d-flex">
                                <div>
                                    <label for="">status</label>
                                    <select class="form-control" wire:model='status'>
                                        <option>All</option>
                                        <option>Processed</option>
                                        <option>Pending</option>
                                        <option>Rejected</option>
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
                                        <th>Client</th>
                                        <th>Amount Deposited</th>
                                        <th>Payment Method</th>
                                        <th>Status</th>
                                        <th>Account Id</th>
                                        <th>Email id</th>
                                        <th>Transaction ID</th>
                                        <th>Date</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($deposits as $deposit)
                                    <tr>
                                    <td>
                                    @if ($deposit->duser)
                                    <a href="{{ route('viewuser', ['id' => $deposit->duser->id]) }}" class="text-info">
                                    {{ $deposit->duser->name }}
                                    </a>
                                    @else
                                    <span class="text-muted">User not found</span>
                                    @endif
                                    </td>
                                    <td>{{ $settings->currency }}{{ number_format($deposit->amount) }}</td>
                                    <td>{{ $deposit->payment_mode }}</td>
                                    <td>
                                    @if ($deposit->status == 'Processed')
                                    <span class="badge badge-success">{{ $deposit->status }}</span>
                                    @else
                                    <span class="badge badge-danger">{{ $deposit->status }}</span>
                                    @endif
                                    </td>
                                    <td>
                                    @if ($deposit->duser)
                                    {{ $deposit->duser->accountid }}
                                    @else
                                    <span class="text-muted">No account ID</span>
                                    @endif
                                    </td>
                                    <td>
                                    @if ($deposit->duser)
                                    {{ $deposit->duser->email }}
                                    @else
                                    <span class="text-muted">No email</span>
                                    @endif
                                    </td>
                                    <td>{{ $deposit->txn_id }}</td>
                                    <td>{{ $deposit->created_at->format('d M Y') }}</td>
                                    <td>
                                    <a href="{{ asset('/' . $deposit->proof) }}" target="_blank" class="btn btn-info btn-sm m-1" title="View payment screenshot">
                                    <i class="fa fa-eye"></i>
                                    </a>
                                    <button wire:click="deleteId({{ $deposit->id }})" data-toggle="modal" data-target="#exampleModal" class="m-1 btn btn-danger btn-sm">
                                    Delete
                                    </button>
                                    <button class="btn btn-warning btn-sm m-1 editDepositBtn"
                                    data-id="{{ $deposit->id }}"
                                    data-amount="{{ $deposit->amount }}"
                                    data-status="{{ $deposit->status }}"
                                    data-email="{{ $deposit->duser->email ?? '' }}"
                                    data-payment_mode="{{ $deposit->payment_mode }}"
                                    data-toggle="modal" data-target="#editDepositModal">
                                    <i class="fa fa-edit"></i> Edit
                                    </button>
                                    @if ($deposit->status != 'Processed')
                                    <!-- <button class="btn btn-primary btn-sm" wire:loading.attr="disabled" wire:click="confirmDeposit({{ $deposit->id }})">
                                     <div class="spinner-border spinner-border-sm" role="status" wire:loading wire:target="confirmDeposit({{ $deposit->id }})">
                                    <span class="sr-only">Loading...</span>
                                    </div> 
                                    Confirm
                                    </button> -->
                                    @endif
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

                            {{ $deposits->links() }}
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
                                    You do not have any deposit record. <br> When your users deposit into
                                    their
                                    account, it will appear here.
                                </p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Edit Deposit Modal -->
<div class="modal fade" id="editDepositModal" tabindex="-1" role="dialog" aria-labelledby="editDepositLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="editDepositForm">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Deposit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true close-btn">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit_id" name="id">

                    <div class="form-group">
                        <label>Amount</label>
                        <input type="number" class="form-control" id="edit_amount" name="amount" required>
                    </div>

                    <div class="form-group">
                        <label>Payment Mode</label>
                        <input type="text" class="form-control" id="edit_payment_mode" name="payment_mode" readonly>
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" id="edit_status" class="form-control" require>
                            <option value="">Choose one</option>
                            <option value="Processed">Processed</option>
                            <option value="Rejected">Rejected</option>
                        </select>
                    </div>
                    <div class="form-group remark">
                        <label>Remark add when rejected </label>
                        <input type="text" class="form-control" id="edit_remark" name="reamrk" >
                    </div>
                    <input type="hidden" class="form-control" id="edit_email" name="email" readonly>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Deposit</button>
                </div>
            </div>
        </form>
    </div>
</div>
@push('scripts')
<script>
$(document).ready(function() {
    $('.remark').hide();
    $('#edit_remark').prop('required', false);

    // ✅ When status changes
    $('#edit_status').on('change', function () {
        let status = $(this).val();

        if (status === 'Rejected') {
            $('.remark').slideDown();                // show
            $('#edit_remark').prop('required', true); // required
        } else {
            $('.remark').slideUp();                  // hide
            $('#edit_remark').prop('required', false);
            $('#edit_remark').val('');               // clear value
        }
    });
    // Open modal and populate fields
    $(document).on('click', '.editDepositBtn', function() {
        $('#edit_id').val($(this).data('id'));
        $('#edit_amount').val($(this).data('amount'));
        $('#edit_payment_mode').val($(this).data('payment_mode'));
        $('#edit_status').val($(this).data('status'));
         $('#edit_email').val($(this).data('email'));
         $('#edit_remark').val($(this).data('remark'));
    });

    // Handle form submit
    $('#editDepositForm').on('submit', function(e) {
        e.preventDefault(); // Stop normal form submit

        let id = $('#edit_id').val();         // READ ID FIRST
        let nurl = '/admin/dashboard/deposits/update/' + id; // MAKE URL
        let formData = $(this).serialize();

        $.ajax({
            url: nurl,
            type: 'POST',
            data: formData,
            success: function(response) {
                $('#editDepositModal').modal('hide');
                alert(response.message);
                location.reload();
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                alert('Something went wrong while updating the deposit.');
            }
        });
    });

});
</script>
@endpush