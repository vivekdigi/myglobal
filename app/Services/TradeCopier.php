<?php

namespace App\Services;

use App\Traits\PingServer;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class TradeCopier
{
    use PingServer;

    public function providers(): Collection|array
    {
        if (Cache::has('providers')) {
            return collect(Cache::get('providers'));
        }

        $response = $this->fetctApi('/master-account');

        throw_if($response->failed(), \Exception::class, $response['message'] ?? 'Failed to fetch providers');

        $value = $response['data'];

        Cache::put('providers', $value, now()->addHour());

        return collect($value);
    }

    public function subscribers(): Collection|array
    {
        if (Cache::has('subscribers')) {
            return collect(Cache::get('subscribers'));
        }

        $response = $this->fetctApi('/trading-accounts');

        throw_if($response->failed(), \Exception::class, $response['message'] ?? 'Failed to fetch subscribers');

        $value = $response['data'];
        Cache::put('subscribers', $value, now()->addHour());

        return collect($value);
    }

    public function accountMetrics(string $accountId, string $type): array
    {
        if (Cache::has("metrics-{$accountId}")) {
            return Cache::get("metrics-{$accountId}");
        }

        $response = $this->fetctApi("/account-metrics/$accountId/$type");

        throw_if($response->failed(), \Exception::class, $response['message'] ?? 'Failed to fetch metrics');

        Cache::put("metrics-{$accountId}", $response['metrics'], now()->addHour());

        return $response['metrics'];
    }

    public function membershipProfile(): array
    {
        if (Cache::has('account-profile')) {
            return Cache::get('account-profile');
        }
        $account = $this->fetctApi('/account-profile');

        throw_if($account->failed(), \Exception::class, $account['message'] ?? 'Failed to fetch account profile');

        Cache::forever('account-profile', $account['data']);

        return $account['data'];
    }

    public function settings(): array
    {
        if (Cache::has('copier-settings')) {
            return Cache::get('copier-settings');
        }
        $settings = $this->fetctApi('/settings');

        throw_if($settings->failed(), \Exception::class, $settings['message'] ?? 'Failed to fetch settings');

        Cache::put('copier-settings', $settings['data'], now()->addHour());

        return $settings['data'];
    }
}
