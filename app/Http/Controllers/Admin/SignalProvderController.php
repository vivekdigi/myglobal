<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SignalService;
use App\Traits\PingServer;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class SignalProvderController extends Controller
{
    use PingServer;

    public function tradeSignals(): View
    {
        return view('admin.signals.tradeSignals', [
            'title' => 'Trading Signals',
        ]);
    }


    public function settings()
    {
        return view('admin.signals.signalSettings', [
            'title' => 'Signals Settings',
        ]);
    }

    public function subscribers(SignalService $signal)
    {
        $subscribers = $signal->subscribers();

        if (Arr::exists($subscribers, 'error') && $subscribers['error'] == true) {
            return redirect()->back()->with('message', $subscribers['errorMessage']);
        }
        return view('admin.signals.subscribers', [
            'title' => 'Subscribers',
            'subscribers' => $subscribers,
        ]);
    }

    public function deleteSubscriber(int $id): RedirectResponse
    {
        $response = $this->fetctApi('/delete/user-sub/' . $id);
        if ($response->failed()) {
            return redirect()->back()->with('message', $response['message']);
        }
        return redirect()->back()->with('success', 'Subscriber deleted successfully');
    }
}
