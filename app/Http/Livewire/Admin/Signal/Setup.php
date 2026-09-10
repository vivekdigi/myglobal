<?php

namespace App\Http\Livewire\Admin\Signal;

use App\Models\SettingsCont;
use App\Services\HelperService;
use App\Services\SignalService;
use App\Traits\PingServer;
use Illuminate\Support\Arr;
use Livewire\Component;

class Setup extends Component
{
    use PingServer;
    public $monthlyFee = '';
    public $quaterlyFee = '';
    public $yearlyFee = '';
    public $chatId = '';
    public $botToken = '';


    public function mount(SignalService $signal): void
    {
        $settings = $signal->setup();

        if (Arr::exists($settings, 'error') && $settings['error'] == true) {
            session()->flash('message', $settings['errorMessage']);
        }

        if (Arr::exists($settings, 'signal_monthly_fee')) {
            $this->monthlyFee = $settings['signal_monthly_fee'];
        }
        if (Arr::exists($settings, 'signal_quartly_fee')) {
            $this->quaterlyFee = $settings['signal_quartly_fee'];
        }
        if (Arr::exists($settings, 'signal_yearly_fee')) {
            $this->yearlyFee = $settings['signal_yearly_fee'];
        }
        if (Arr::exists($settings, 'chat_id')) {
            $this->chatId = $settings['chat_id'];
        }
        if (Arr::exists($settings, 'telegram_bot_api')) {
            $this->botToken = $settings['telegram_bot_api'];
        }
    }

    public function render()
    {
        return view('livewire.admin.signal.setup');
    }

    public function saveSettings(): void
    {
        $settings = SettingsCont::find(1);

        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
            $link = "https";
        } else {
            $link = "http";
        }
        $website = $link . '://' . $_SERVER['HTTP_HOST'] . '/get-started';

        $response = $this->fetctApi("/save-signal-settings", [
            'website' => $website,
            'monthly' => $this->monthlyFee,
            'quaterly' => $this->quaterlyFee,
            'yearly' => $this->yearlyFee,
            'telegram_link' => '',
            'telegram_bot_api' => $this->botToken
        ], 'PUT');

        if ($response->successful()) {
            $settings->telegram_bot_api = $this->botToken;
            $settings->save();
            HelperService::cacheForget('signal-settings');
        }

        $respond = $this->backWithResponse($response);
        session()->flash($respond['type'], $respond['message']);
    }

    public function getChatId()
    {
        $response = $this->fetctApi("/chat-id");
        $respond = $this->backWithResponse($response);
        HelperService::cacheForget('signal-settings');
        session()->flash($respond['type'], $respond['message']);
        return redirect('admin/dashboard/signal-settings');
    }

    public function deleteChatId()
    {
        $response = $this->fetctApi("/delete-id");
        $respond = $this->backWithResponse($response);
        HelperService::cacheForget('signal-settings');
        session()->flash($respond['type'], $respond['message']);
        return redirect('admin/dashboard/signal-settings');
    }
}
