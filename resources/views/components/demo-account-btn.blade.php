{{-- Demo Account Request Button Component --}}
@php
    $hasRequest = !is_null($demoRequest);
    $status     = $hasRequest ? $demoRequest->status : null;
@endphp

<div class="demo-account-section">
    <div class="text-center">
        @if ($hasRequest)
            @if ($status === 'approved')
                <button disabled style="background:#052a36;color:#fff;border:none;border-radius:50px;font-size:.78rem;font-weight:700;padding:10px 14px;cursor:not-allowed;letter-spacing:.3px;width:100%;display:flex;align-items:center;justify-content:center;white-space:nowrap;margin-bottom:8px;">
                    <i class="fas fa-check-circle mr-1"></i> Demo Approved ✓
                </button>
                <small class="d-block" style="font-size:.76rem;color:rgba(255,255,255,0.85);font-weight:500;line-height:1.3;">Your demo account is ready to use</small>
            @elseif ($status === 'rejected')
                <button disabled style="background:#ff1744;color:#fff;border:none;border-radius:50px;font-size:.78rem;font-weight:700;padding:10px 14px;cursor:not-allowed;letter-spacing:.3px;width:100%;display:flex;align-items:center;justify-content:center;white-space:nowrap;margin-bottom:8px;">
                    <i class="fas fa-times-circle mr-1"></i> Demo Rejected
                </button>
                <small class="d-block text-muted" style="font-size:.7rem;line-height:1.3;">Your request was not approved</small>
            @else
                <button disabled style="background:#ff9100;color:#1a1a1a;border:2px solid #ff9100;border-radius:50px;font-size:.78rem;font-weight:800;padding:10px 14px;cursor:not-allowed;letter-spacing:.4px;width:100%;display:flex;align-items:center;justify-content:center;white-space:nowrap;margin-bottom:8px;">
                    <i class="fas fa-clock mr-1"></i> Demo Pending
                </button>
                <small class="d-block" style="font-size:.76rem;color:rgba(255,255,255,0.85);font-weight:500;line-height:1.3;">Your request is under review</small>
            @endif
        @else
            {{-- Demo account request button is hidden --}}
            {{--
            <button id="demoRequestBtn" onclick="submitDemoRequest()" style="background:#f5a623;color:#1a1a1a;border:2px solid #f5a623;border-radius:50px;font-size:.78rem;font-weight:800;padding:12px 28px;cursor:pointer;letter-spacing:.4px;text-shadow:none;width:100%;display:block;">
                <i class="fas fa-flask mr-1"></i> Demo Account
            </button>
            <small class="d-block mt-2" style="font-size:.85rem;color:#fff;font-weight:500;margin-top:8px;">Request a demo account</small>
            --}}
        @endif
    </div>
</div>

<style>
    @media (max-width: 576px) {
        .demo-account-section button {
            font-size: 0.7rem !important;
            padding: 8px 16px !important;
        }
        .demo-account-section small {
            font-size: 0.65rem !important;
            color: #fff !important;
        }
    }
</style>

<script>
function submitDemoRequest() {
    var btn = document.getElementById('demoRequestBtn');
    if (!btn || btn.disabled) return;
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Submitting...';
    btn.style.background = '#757575';

    var xhr = new XMLHttpRequest();
    xhr.open('POST', '{{ route("demo.request") }}', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
    xhr.setRequestHeader('Accept', 'application/json');

    xhr.onreadystatechange = function () {
        if (xhr.readyState !== 4) return;
        var data = {};
        try { data = JSON.parse(xhr.responseText); } catch(e) {
            btn.disabled = false;
            btn.style.background = '#aa00ff';
            btn.innerHTML = '<i class="fas fa-flask mr-1"></i> Demo Account';
            alert('Server error (' + xhr.status + '). Please try again.');
            return;
        }
        if (xhr.status === 200 && data.success) {
            btn.style.background = '#ff9100';
            btn.style.color = '#1a1a1a';
            btn.style.border = '2px solid #ff9100';
            btn.innerHTML = '<i class="fas fa-clock mr-1"></i> Demo Pending';
            btn.disabled = true;
            btn.style.cursor = 'not-allowed';
            if (typeof swal === 'function') { swal('Success!', data.message, 'success'); }
        } else {
            btn.style.background = '#ff9100';
            btn.style.color = '#1a1a1a';
            btn.style.border = '2px solid #ff9100';
            btn.innerHTML = '<i class="fas fa-clock mr-1"></i> Demo Pending';
            btn.disabled = true;
            btn.style.cursor = 'not-allowed';
        }
    };
    xhr.onerror = function () {
        btn.disabled = false;
        btn.style.background = '#aa00ff';
        btn.innerHTML = '<i class="fas fa-flask mr-1"></i> Demo Account';
        alert('Network error. Please try again.');
    };
    xhr.send(JSON.stringify({}));
}
</script>
