<?php

namespace App\Http\Livewire\Admin\Mam;

use App\Models\SymbolMap;
use Livewire\Component;
use Livewire\WithPagination;

class SymbolMapping extends Component
{
    use WithPagination;
    public $from;
    public $to;
    public $addSymbol = false;

    public function render()
    {
        return view('livewire.admin.mam.symbol-mapping', [
            'symbols' => SymbolMap::orderByDesc('id')->paginate(10),
        ]);
        //~ai\p)WTP$xE0+#
    }

    // add symbol mapping
    public function addSymbolMapping(): void
    {
        $this->validate([
            'from' => 'required',
            'to' => 'required',
        ]);

        SymbolMap::create([
            'from_symbol' => $this->from,
            'to_symbol' => $this->to,
        ]);

        $this->from = '';
        $this->to = '';
        $this->addSymbol = false;
        session()->flash('success', 'Symbol mapping added successfully');
    }

    // delete symbol mapping
    public function deleteSymbolMapping(int $id): void
    {
        $symbol = SymbolMap::findOrFail($id);
        $symbol->delete();
        session()->flash('success', 'Symbol mapping deleted successfully');
    }
}
