<button type="button" class="btn btn-primary mt-5" data-bs-toggle="modal" data-bs-target="#exampleModalCenter">
    Mark as Completed
</button>

<div id="exampleModalCenter" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalCenterTitle">Upload payment
                    receipt</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="{{ route('savedeposit') }}" enctype="multipart/form-data"
                onsubmit="document.getElementById('savebtn').disabled = true;">
                @csrf
                <div class="modal-body m-0">
                    <div class="mb-3">
                        <input type="file" name="proof" class="form-control" required>
                    </div>
                    <input type="hidden" name="amount" value="{{ $amount }}">
                    <input type="hidden" name="paymethd_method" value="{{ $payment_mode->name }}">
                </div>
                <div class="modal-footer m-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="savebtn">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
