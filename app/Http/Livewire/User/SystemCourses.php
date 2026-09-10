<?php

namespace App\Http\Livewire\User;

use App\Models\Settings;
use App\Services\LearnService;
use App\Traits\PingServer;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;

class SystemCourses extends Component
{
    use WithPagination, PingServer;
    protected $paginationTheme = 'bootstrap';
    public $lessons;
    public $category = 'Artificial Intelligcence';

    public function mount(LearnService $learn)
    {
        if (Arr::exists($learn->courses(), 'error') && $learn->courses()['error'] == true) {
            session()->flash('message', $learn->courses()['errorMessage']);
            return redirect()->route('dashboard');
        }
    }
    public function render(LearnService $learn)
    {
        $settings = Settings::select('theme')->find(1);

        $info = json_decode($learn->courses());

        return view("{$settings->theme}.livewire.user.system-courses", [
            'categories' => json_decode($learn->categories()),
            'courses' => $info->courses->data,
        ]);
    }

    public function changeCategory($cat)
    {
        $this->category = $cat == 'others' ? null : $cat;
    }
}
