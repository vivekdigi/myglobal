<?php

namespace App\Http\Livewire\User\Deposit;

use App\Models\Settings;
use App\Models\Wdmethod;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class Index extends Component
{
    public $methodSelected;
    public $amountSelected;
    public $amount;

    public function mount()
    {
        $lastMethod = Wdmethod::select('name', 'id', 'type', 'status', 'img_url')->where(function (Builder $query) {
            $query->where('type', '=', 'deposit')
                ->orWhere('type', '=', 'both');
        })->where('status', 'enabled')->latest()->first();

        if ($lastMethod) {
            $this->methodSelected = $lastMethod->name;
        }
    }

    public function render()
    {
        $settings = Settings::select('theme')->find(1);
        return view("{$settings->theme}.livewire.user.deposit.index", [
            'depositMethods' => Wdmethod::select('name', 'id', 'type', 'status', 'img_url')->where(function (Builder $query) {
                $query->where('type', '=', 'deposit')
                    ->orWhere('type', '=', 'both');
            })->where('status', 'enabled')->orderByDesc('id')->get(),
        ]);
    }

    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }
}
