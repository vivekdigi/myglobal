<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DemoAccountRequest;
use Illuminate\Http\Request;

class DemoRequestController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $requests = DemoAccountRequest::with('user')
            ->when($search, function ($query) use ($search) {
                $query->where('user_name', 'like', "%{$search}%")
                      ->orWhere('user_email', 'like', "%{$search}%");
            })
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString(); // keeps ?search= in pagination links

        return view('admin.demo-requests.index', [
            'title'    => 'Demo Account Requests',
            'requests' => $requests,
            'search'   => $search,
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        $demoRequest = DemoAccountRequest::findOrFail($id);
        $demoRequest->update([
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Demo request updated to ' . ucfirst($request->status) . '.');
    }

    public function destroy($id)
    {
        DemoAccountRequest::findOrFail($id)->delete();

        return redirect()->route('admin.demo.requests')->with('success', 'Demo request deleted successfully.');
    }

    public function bulkDestroy(Request $request)
    {
        $request->validate(['ids' => 'required|array', 'ids.*' => 'integer']);

        $count = DemoAccountRequest::whereIn('id', $request->ids)->count();
        DemoAccountRequest::whereIn('id', $request->ids)->delete();

        return redirect()->route('admin.demo.requests')->with('success', "{$count} demo request(s) deleted successfully.");
    }
}