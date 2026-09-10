<?php

namespace App\Http\Controllers\Admin;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Imports\UsersImport;
use App\Jobs\ProcessLeadCsvDoc;
use Illuminate\Support\Facades\Response;

class ImportController extends Controller
{
    //
    public function fileImport(Request $request)
    {
        $request->validate([
            'file' => 'mimes:csv,xlsx,xls',
        ]);

        try {
            // dispatch(new ProcessLeadCsvDoc($request->file('file')));
            Excel::import(new UsersImport, $request->file);
            return redirect()->back()->with('success', 'Leads Sucessfully imported!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('message', 'File not found!');
        }
    }

    public function downloadDoc()
    {
        try {
            $download_path = (public_path() .  '/storage/' . 'leads.xlsx');
            return (Response::download($download_path));
        } catch (\Throwable $th) {
            return redirect()->back()->with('message', 'File not found!');
        }
    }
}
