{{-- Third Account Request Button Component --}}
@php
    $hasRequest   = !is_null($thirdRequest);
    $status       = $hasRequest ? $thirdRequest->status : null;
    $totalDeposit = \App\Models\Deposit::where('user', Auth::id())->where('status', 'Processed')->sum('amount');
@endphp

<div class="third-account-section">
    <div class="text-center">
        @if ($hasRequest)
            @if ($status === 'approved')
                <button disabled style="background:#000000;color:#fff;border:none;border-radius:50px;font-size:.78rem;font-weight:700;padding:10px 14px;cursor:not-allowed;letter-spacing:.3px;width:100%;display:flex;align-items:center;justify-content:center;white-space:nowrap;margin-bottom:8px;">
                    <i class="fas fa-check-circle mr-1"></i> 3rd Acct Approved ✓
                </button>
                <small class="d-block" style="font-size:.76rem;color:rgba(255,255,255,0.85);font-weight:500;line-height:1.3;">Your third account is ready to use</small>
            @elseif ($status === 'rejected')
                <button disabled style="background:#ff1744;color:#fff;border:none;border-radius:50px;font-size:.78rem;font-weight:700;padding:10px 14px;cursor:not-allowed;letter-spacing:.3px;width:100%;display:flex;align-items:center;justify-content:center;white-space:nowrap;margin-bottom:8px;">
                    <i class="fas fa-times-circle mr-1"></i> 3rd Acct Rejected
                </button>
                <small class="d-block text-muted" style="font-size:.7rem;line-height:1.3;">Your request was not approved</small>
            @else
                <button disabled style="background:#ff9100;color:#1a1a1a;border:2px solid #ff9100;border-radius:50px;font-size:.78rem;font-weight:800;padding:10px 14px;cursor:not-allowed;letter-spacing:.4px;width:100%;display:flex;align-items:center;justify-content:center;white-space:nowrap;margin-bottom:8px;">
                    <i class="fas fa-clock mr-1"></i> 3rd Acct Pending
                </button>
                <small class="d-block" style="font-size:.76rem;color:rgba(255,255,255,0.85);font-weight:500;line-height:1.3;">Your request is under review</small>
            @endif
        @else
            <button id="thirdAccountBtn" onclick="submitThirdAccountRequest()" style="background:#00bcd4;color:#1a1a1a;border:2px solid #00bcd4;border-radius:50px;font-size:.78rem;font-weight:800;padding:10px 14px;cursor:pointer;letter-spacing:.4px;width:100%;display:flex;align-items:center;justify-content:center;white-space:nowrap;margin-bottom:8px;">
                <i class="fas fa-user-plus mr-1"></i> 3rd Account
            </button>
            <small class="d-block" style="font-size:.76rem;color:rgba(255,255,255,0.85);font-weight:500;line-height:1.3;">Request a third account</small>
        @endif
    </div>
</div>

<style>
    @media (max-width: 576px) {
        .third-account-section button {
            font-size: 0.7rem !important;
            padding: 8px 16px !important;
        }
        .third-account-section small {
            font-size: 0.65rem !important;
            margin-top: 12px !important;
            color: #000 !important;
        }
    }
</style>

<script>
function submitThirdAccountRequest() {
    var btn = document.getElementById('thirdAccountBtn');
    if (!btn || btn.disabled) return;

    var totalDeposit = {{ (float) $totalDeposit }};
    var minRequired = 1;

    if (totalDeposit < minRequired) {
        if (typeof swal === 'function') {
            swal('Deposit Too Low', 'Your deposit is too low to request a third account. Please make a deposit first.', 'warning');
        } else {
            alert('Your deposit is too low to request a third account. Please make a deposit first.');
        }
        return;
    }

    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Submitting...';
    btn.style.background = '#757575';

    var xhr = new XMLHttpRequest();
    xhr.open('POST', '{{ route("third.account.request") }}', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
    xhr.setRequestHeader('Accept', 'application/json');

    xhr.onreadystatechange = function () {
        if (xhr.readyState !== 4) return;
        var data = {};
        try { data = JSON.parse(xhr.responseText); } catch(e) {
            btn.disabled = false;
            btn.style.background = '#00bcd4';
            btn.innerHTML = '<i class="fas fa-user-plus mr-1"></i> 3rd Account';
            alert('Server error (' + xhr.status + '). Please try again.');
            return;
        }
        if (xhr.status === 200 && data.success) {
            btn.style.background = '#ff9100';
            btn.style.color = '#1a1a1a';
            btn.style.border = '2px solid #ff9100';
            btn.innerHTML = '<i class="fas fa-clock mr-1"></i> 3rd Acct Pending';
            btn.disabled = true;
            btn.style.cursor = 'not-allowed';
            if (typeof swal === 'function') { swal('Success!', data.message, 'success'); }
        } else {
            btn.disabled = false;
            btn.style.background = '#00bcd4';
            btn.style.color = '#1a1a1a';
            btn.style.border = '2px solid #00bcd4';
            btn.innerHTML = '<i class="fas fa-user-plus mr-1"></i> 3rd Account';
            btn.style.cursor = 'pointer';
            if (typeof swal === 'function') {
                swal('Notice', data.message || 'Request could not be processed.', 'warning');
            } else {
                alert(data.message || 'Request could not be processed.');
            }
        }
    };
    xhr.onerror = function () {
        btn.disabled = false;
        btn.style.background = '#00bcd4';
        btn.innerHTML = '<i class="fas fa-user-plus mr-1"></i> 3rd Account';
        alert('Network error. Please try again.');
    };
    xhr.send(JSON.stringify({}));
}
</script>
