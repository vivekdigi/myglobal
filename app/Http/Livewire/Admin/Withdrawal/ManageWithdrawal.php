<?php

namespace App\Http\Livewire\Admin\Withdrawal;

use App\Models\Withdrawal;
use Livewire\Component;
use Livewire\WithPagination;

class ManageWithdrawal extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $search = '';
    public $order = 'desc';
    public $status = 'All';
    public $perPage = 10;
    public $toDate = '';
    public $fromDate = '';
    public $deleteId = '';

    public function render()
    {
        return view('livewire.admin.withdrawal.manage-withdrawal', [
            'withdrawals' => Withdrawal::ofSearch($this->search)->ofStatus($this->status)->orderBy('id', $this->order)->with('duser:id,name,accountid,email')->ofDate($this->fromDate, $this->toDate)->paginate($this->perPage),
        ]);
    }

    //reset all filter
    public function resetFilter()
    {
        $this->reset(['search', 'order', 'status', 'perPage', 'toDate', 'fromDate']);
    }

    public function deleteId($id)
    {
        $this->deleteId = $id;
    }

    public function delete()
    {
        $withdrawal = Withdrawal::findOrFail($this->deleteId);
        try {
            $withdrawal->delete();
            session()->flash('success', 'Withrdwal deleted successfully!');
        } catch (\Throwable $th) {
            session()->flash('error', 'Something went wrong!, Withrdwal record does not exist.');
        }
    }
}
