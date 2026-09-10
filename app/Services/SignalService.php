<?php

namespace App\Services;

use App\Traits\PingServer;
use Illuminate\Support\Facades\Cache;

class SignalService
{
    use PingServer;
    public function __construct()
    {
        //
    }

    public function setup(): array
    {
        if (Cache::has('signal-settings')) {
            return Cache::get('signal-settings');
        }

        $response = $this->fetctApi('/signal-settings');
        if ($response->failed()) {
            return [
                'error' => true,
                'errorMessage' => $response['message'] ?? 'Something went wrong',
            ];
        }

        $settings =  $response['data']['settings'];

        Cache::put('signal-settings', $settings, now()->addHour());

        return $settings ?? [];
    }

    public function subscribers(): array
    {
        if (Cache::has('signal-subscribers')) {
            return Cache::get('signal-subscribers');
        }

        $response = $this->fetctApi('/signal-subscribers');

        if ($response->failed()) {
            return [
                'error' => true,
                'errorMessage' => $response['message'] ?? 'Something went wrong',
            ];
        }

        $subscribers = $response['data']['subscribers'];
        Cache::put('signal-subscribers', $subscribers, now()->addHour());

        return $subscribers;
    }

    // get all signals
    public function signals(): array
    {
        if (Cache::has('trading-signals')) {
            return Cache::get('trading-signals');
        }

        $response = $this->fetctApi('/trading-signals');

        if ($response->failed()) {
            return [
                'error' => true,
                'errorMessage' => $response['message'] ?? 'Something went wrong',
            ];
        }

        $signals = $response['data']['signals'];
        Cache::put('trading-signals', $signals, now()->addHour());

        return $signals;
    }

    // get user subscription
    public function subscription(string $id)
    {
        if (Cache::has('signal-subscription-' . $id)) {
            return Cache::get('signal-subscription-' . $id);
        }
        $response = $this->fetctApi('/subscription', [
            'id' => $id
        ]);

        if ($response->failed()) {
            return [
                'error' => true,
                'errorMessage' => 'Something went wrong, please contact support',
            ];
        }
        $sub = $response['data'];
        Cache::put('signal-subscription-' . $id, $sub, now()->addHour());
        return $sub;
    }
}
