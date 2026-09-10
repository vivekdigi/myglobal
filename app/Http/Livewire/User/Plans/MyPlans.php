<?php

namespace App\Http\Livewire\User\Plans;

use App\Models\Settings;
use App\Models\User_plans;
use Livewire\Component;
use Livewire\WithPagination;

class MyPlans extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $sortValue;

    public function render()
    {
        $settings = Settings::select('theme')->find(1);
        return view("{$settings->theme}.livewire.user.plans.my-plans", [
            'plans' => User_plans::where('user', auth()->user()->id)
                ->with('dplan')
                ->sort($this->sortValue)
                ->latest()
                ->paginate(10),
        ]);
    }
}
