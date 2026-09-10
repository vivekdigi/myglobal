<div class="text-center py-5">
    <form method="POST" action="{{ route('paybyflutterwave') }}">
        {{ csrf_field() }}

        <input type="hidden" name="name" value="{{ Auth::user()->name }}" />
        <input name="email" type="hidden" value="{{ Auth::user()->email }}" />
        <input name="phone" type="hidden" value="{{ Auth::user()->phone }}" />
        <input name="amount" type="hidden" value="{{ $amount }}" />

        <button class="py-2 btn btn-primary" type="submit">
            <i class="bi bi-credit-card"></i>
            Pay with Flutterwave
        </button>
    </form>
</div>
