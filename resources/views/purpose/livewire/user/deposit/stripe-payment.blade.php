<div class="text-center py-5">
    <form id="payment-form" class="sr-payment-form">
        @csrf
        <div class="sr-combo-inputs-row mb-3">
            <div class="sr-input sr-card-element" id="card-element">
            </div>
        </div>

        <button id="stripesubmit" class="button">
            <div class="spinner d-none" id="spinner"></div>
            <span id="buttontext" class="">Pay</span>
        </button>
    </form>

    <div class="hidden row" id="stripesuccess">
        <div class="col-lg-12">
            <span>Payment Completed, redirecting.....</span>
        </div>
    </div>

    <form id="selectform" method="POST" action="javascript:void(0)">
        @csrf
        <input type="hidden" name="amount" value="{{ $amount }}">
    </form>
</div>
