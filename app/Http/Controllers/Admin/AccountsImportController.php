<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\AccountsImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class AccountsImportController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $accounts = DB::table('accounts')
            ->when($search, function ($q) use ($search) {
                $q->where('account_id', 'like', "%{$search}%");
            })
            ->orderByDesc('id')
            ->paginate(20)
            ->withQueryString();

        return view('admin.accounts.index', [
            'title'    => 'Accounts',
            'accounts' => $accounts,
            'search'   => $search,
        ]);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt,xlsx,xls|max:5120',
        ]);

        try {
            $import = new AccountsImport();
            Excel::import($import, $request->file('file'));

            $msg = "Import complete — {$import->inserted} inserted, {$import->updated} updated";
            if ($import->skipped > 0) {
                $msg .= ", {$import->skipped} skipped (empty account_id)";
            }
            $msg .= '.';

            return redirect()->route('admin.accounts.index')->with('success', $msg);

        } catch (\Throwable $e) {
            return redirect()->route('admin.accounts.index')
                ->with('message', 'Import failed: ' . $e->getMessage());
        }
    }

    public function downloadSample()
    {
        $file = public_path('samples/accounts-sample.csv');

        if (!file_exists($file)) {
            return redirect()->back()->with('message', 'Sample file not found.');
        }

        return response()->download($file, 'accounts-sample.csv', [
            'Content-Type' => 'text/csv',
        ]);
    }
}
