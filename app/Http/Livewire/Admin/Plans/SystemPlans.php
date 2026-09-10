<?php

namespace App\Http\Livewire\Admin\Plans;

use App\Models\Plans;
use App\Models\User;
use App\Models\User_plans;
use Livewire\Component;
use Livewire\WithPagination;

class SystemPlans extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $planId;

    public function render()
    {
        return view('livewire.admin.plans.system-plans', [
            'plans' => Plans::orderByDesc('id')->paginate(10),
        ]);
    }

    public function deleteId(int $id)
    {
        $this->planId = $id;
    }
    public function deletePlan()
    {
        $plan = Plans::with('userPlans')->find($this->planId);
        // check if there are users with this plan in users table thought the relationship

        if ($plan->userPlans()->count() > 0) {
            foreach ($plan->userPlans as $userPlan) {
                $userPlan->delete();
            }
        }

        $plan->delete();

        session()->flash('success', 'Plan deleted successfully.');
    }

    public function markPlanAs(int $planId, string $status)
    {
        $plan = Plans::find($planId);
        $plan->update([
            'status' => $status
        ]);
        session()->flash('success', 'Plan status updated successfully.');
    }

    public function removeInfoSession()
    {
        session(['removeInfo' => true]);
    }
}
