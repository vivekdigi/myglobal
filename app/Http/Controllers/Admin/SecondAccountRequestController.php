<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CryptoAccount;
use App\Models\SecondAccountRequest;
use App\Models\Settings;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use App\Mail\WelcomeEmail;

class SecondAccountRequestController extends Controller
{
    // ─── Requests listing ────────────────────────────────────────────────────

    public function index(Request $request)
    {
        $search = $request->get('search');

        $requests = SecondAccountRequest::with('user')
            ->when($search, function ($q) use ($search) {
                $q->where('user_name', 'like', "%{$search}%")
                  ->orWhere('user_email', 'like', "%{$search}%");
            })
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        // Get user_ids that already have a secondary account created
        $createdUserIds = User::where('is_secondary', 1)
            ->whereNotNull('parent_user_id')
            ->pluck('parent_user_id')
            ->toArray();

        // Count of secondary accounts per parent user_id
        $secondaryCountMap = User::where('is_secondary', 1)
            ->whereNotNull('parent_user_id')
            ->selectRaw('parent_user_id, count(*) as cnt')
            ->groupBy('parent_user_id')
            ->pluck('cnt', 'parent_user_id');

        return view('admin.second-account-requests.index', [
            'title'             => 'Second Account Requests',
            'requests'          => $requests,
            'search'            => $search,
            'createdUserIds'    => $createdUserIds,
            'secondaryCountMap' => $secondaryCountMap,
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:approved,rejected']);

        SecondAccountRequest::findOrFail($id)->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Request updated to ' . ucfirst($request->status) . '.');
    }

    public function destroy($id)
    {
        SecondAccountRequest::findOrFail($id)->delete();

        return redirect()->route('admin.second.requests')->with('success', 'Second account request deleted successfully.');
    }

    public function bulkDestroy(Request $request)
    {
        $request->validate(['ids' => 'required|array', 'ids.*' => 'integer']);

        $count = SecondAccountRequest::whereIn('id', $request->ids)->count();
        SecondAccountRequest::whereIn('id', $request->ids)->delete();

        return redirect()->route('admin.second.requests')->with('success', "{$count} second account request(s) deleted successfully.");
    }

    // ─── Delete secondary user account (soft delete) ─────────────────────────

    public function destroySecondary($id)
    {
        $secondary = User::where('id', $id)->where('is_secondary', 1)->firstOrFail();

        // Soft delete — sets deleted_at, does NOT remove from DB
        $secondary->delete();

        return redirect()->route('admin.secondary.list')->with('success', 'Secondary account moved to trash. You can restore it anytime.');
    }

    public function bulkDestroySecondary(Request $request)
    {
        $request->validate(['ids' => 'required|array', 'ids.*' => 'integer']);

        $count = User::whereIn('id', $request->ids)->where('is_secondary', 1)->count();
        User::whereIn('id', $request->ids)->where('is_secondary', 1)->delete();

        return redirect()->route('admin.secondary.list')->with('success', "{$count} secondary account(s) moved to trash.");
    }

    // ─── Trashed secondary accounts ──────────────────────────────────────────

    public function trashedSecondary(Request $request)
    {
        $search = $request->get('search');

        $accounts = User::onlyTrashed()
            ->where('is_secondary', 1)
            ->with('parentUser')
            ->when($search, function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('accountid', 'like', "%{$search}%");
            })
            ->orderByDesc('deleted_at')
            ->paginate(15)
            ->withQueryString();

        return view('admin.second-account-requests.trashed', [
            'title'    => 'Trashed Secondary Accounts',
            'accounts' => $accounts,
            'search'   => $search,
        ]);
    }

    public function restoreSecondary($id)
    {
        $secondary = User::onlyTrashed()->where('id', $id)->where('is_secondary', 1)->firstOrFail();
        $secondary->restore();

        return redirect()->route('admin.secondary.trashed')->with('success', "Account {$secondary->accountid} restored successfully.");
    }

    public function bulkRestoreSecondary(Request $request)
    {
        $request->validate(['ids' => 'required|array', 'ids.*' => 'integer']);

        $count = User::onlyTrashed()->whereIn('id', $request->ids)->where('is_secondary', 1)->count();
        User::onlyTrashed()->whereIn('id', $request->ids)->where('is_secondary', 1)->restore();

        return redirect()->route('admin.secondary.trashed')->with('success', "{$count} account(s) restored successfully.");
    }

    public function forceDestroySecondary($id)
    {
        $secondary = User::onlyTrashed()->where('id', $id)->where('is_secondary', 1)->firstOrFail();

        if ($secondary->parent_user_id) {
            User::where('id', $secondary->parent_user_id)->update(['accountid_sec' => null]);
        }
        CryptoAccount::where('user_id', $secondary->id)->delete();
        $secondary->forceDelete();

        return redirect()->route('admin.secondary.trashed')->with('success', 'Account permanently deleted.');
    }

    // ─── Secondary accounts listing ──────────────────────────────────────────

    public function secondaryList(Request $request)
    {
        $search = $request->get('search');

        $accounts = User::where('is_secondary', 1)
            ->with('parentUser')
            ->when($search, function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('accountid', 'like', "%{$search}%");
            })
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        // Attach accounts table credentials
        $accounts->getCollection()->transform(function ($user) {
            $user->account_credentials = DB::table('accounts')
                ->where('account_id', $user->accountid)
                ->first();
            return $user;
        });

        return view('admin.second-account-requests.secondary-list', [
            'title'    => 'Secondary Accounts',
            'accounts' => $accounts,
            'search'   => $search,
            'settings' => Settings::find(1),
        ]);
    }

    // ─── Create secondary account form ───────────────────────────────────────

    public function createForm(Request $request)
    {
        $users = User::where('is_secondary', 0)
            ->select('id', 'name', 'email', 'accountid')
            ->orderBy('name')
            ->get();

        // Next account ID
        $lastAccountId = User::orderByDesc('id')->value('accountid');
        $nextAccountId = $lastAccountId ? (int)$lastAccountId + 1 : 10200;

        // Pre-select user if coming from request
        $preselect = null;
        if ($request->get('user_id')) {
            $preselect = User::find($request->get('user_id'));
        }

        return view('admin.second-account-requests.create', [
            'title'         => 'Create Secondary Account',
            'users'         => $users,
            'nextAccountId' => $nextAccountId,
            'preselect'     => $preselect,
        ]);
    }

    // ─── Store secondary account ──────────────────────────────────────────────

    public function store(Request $request)
    {
        $request->validate([
            'parent_user_id' => 'required|exists:users,id',
            'accountid'      => 'required|unique:users,accountid',
            'email'          => 'required|email|unique:users,email',
            'login_password' => 'required|min:6',
        ]);

        $parent   = User::findOrFail($request->parent_user_id);
        $settings = Settings::find(1);

        // Build user data
        $userData = [
            'name'           => $parent->name,
            'email'          => $request->email,
            'username'       => $request->email,
            'phone'          => $parent->phone,
            'country'        => $parent->country,
            'password'       => Hash::make($request->login_password),
            'accountid'      => $request->accountid,
            'is_secondary'   => 1,
            'parent_user_id' => $parent->id,
            'status'         => 'active',
            'ref_link'       => $settings->site_address . '/ref/' . $request->accountid,
        ];

        // Add plain password if column exists
        if (\Schema::hasColumn('users', 'login_password_plain')) {
            $userData['login_password_plain'] = $request->login_password;
        }

        // Create secondary user
        $secondary = User::create($userData);

        // Create crypto account
        CryptoAccount::create(['user_id' => $secondary->id]);

        // DO NOT insert into accounts table — secondary account uses parent's
        // credentials from accounts table. Inserting here would create duplicates
        // visible in manage users page.

        // Update parent user's accountid_sec
        $parent->update(['accountid_sec' => $request->accountid]);

        // Mark second account request as approved if exists
        SecondAccountRequest::where('user_id', $parent->id)
            ->update(['status' => 'approved']);

        // Send welcome email with credentials to user and support
        $this->sendAccountWelcomeEmail($secondary, $parent, $request);

        return redirect()->route('admin.secondary.list')
            ->with('success', "Secondary account {$request->accountid} created successfully for {$parent->name}. Welcome email sent.");
    }

    // ─── Update login password for secondary account ─────────────────────────

    public function updateLoginPassword(Request $request, $id)
    {
        $request->validate([
            'login_password' => 'required|min:6',
        ]);

        $user = User::where('id', $id)->where('is_secondary', 1)->firstOrFail();

        $updateData = ['password' => Hash::make($request->login_password)];

        if (Schema::hasColumn('users', 'login_password_plain')) {
            $updateData['login_password_plain'] = $request->login_password;
        }

        $user->update($updateData);

        return redirect()->back()->with('success', "Login password updated for {$user->name} (Account: {$user->accountid}).");
    }

    public function generatePasswords()
    {
        return response()->json([
            'investor_password' => strtoupper(Str::random(4)) . rand(10, 99) . Str::random(2) . '*',
            'master_password'   => strtoupper(Str::random(4)) . rand(10, 99) . Str::random(2) . '*',
        ]);
    }

    // ─── Fetch account credentials for a user (AJAX) ─────────────────────────

    public function fetchUserCredentials(Request $request)
    {
        $user = User::findOrFail($request->user_id);

        // Fetch from accounts table using user's accountid
        $account = DB::table('accounts')
            ->where('account_id', $user->accountid)
            ->first();

        // Next account ID for the NEW secondary account
        $lastAccountId = User::orderByDesc('id')->value('accountid');
        $nextAccountId = $lastAccountId ? (int)$lastAccountId + 1 : 10200;

        // Auto email suggestion with prefix (default: 2, or 3, 4)
        $prefix         = $request->get('prefix', '2');
        $emailParts     = explode('@', $user->email);
        $suggestedEmail = $prefix . 'majesty_' . $emailParts[0] . '@' . ($emailParts[1] ?? 'majesty.com');

        return response()->json([
            // User info
            'accountid'         => $user->accountid,       // primary account id (display only)
            'name'              => $user->name,
            'email'             => $user->email,
            'suggested_email'   => $suggestedEmail,

            // New account ID (auto last+1)
            'next_account_id'   => $nextAccountId,

            // Passwords fetched from accounts table of the PRIMARY account
            'investor_password' => $account->investor_password ?? 'Not found in accounts table',
            'master_password'   => $account->master_password   ?? 'Not found in accounts table',

            // Flag if account row exists
            'account_found'     => $account ? true : false,
        ]);
    }

    // ─── Create third account form ───────────────────────────────────────────

    public function createThirdForm(Request $request)
    {
        $users = User::where('is_secondary', 0)
            ->select('id', 'name', 'email', 'accountid')
            ->orderBy('name')
            ->get();

        $lastAccountId = User::orderByDesc('id')->value('accountid');
        $nextAccountId = $lastAccountId ? (int)$lastAccountId + 1 : 10200;

        $preselect = null;
        if ($request->get('user_id')) {
            $preselect = User::find($request->get('user_id'));
        }

        return view('admin.third-account-requests.create', [
            'title'         => 'Create Third Account',
            'users'         => $users,
            'nextAccountId' => $nextAccountId,
            'preselect'     => $preselect,
        ]);
    }

    // ─── Store third account ──────────────────────────────────────────────────

    public function storeThird(Request $request)
    {
        $request->validate([
            'parent_user_id' => 'required|exists:users,id',
            'accountid'      => 'required|unique:users,accountid',
            'email'          => 'required|email|unique:users,email',
            'login_password' => 'required|min:6',
        ]);

        $parent   = User::findOrFail($request->parent_user_id);
        $settings = Settings::find(1);

        $userData = [
            'name'           => $parent->name,
            'email'          => $request->email,
            'username'       => $request->email,
            'phone'          => $parent->phone,
            'country'        => $parent->country,
            'password'       => Hash::make($request->login_password),
            'accountid'      => $request->accountid,
            'is_secondary'   => 2,
            'parent_user_id' => $parent->id,
            'status'         => 'active',
            'ref_link'       => $settings->site_address . '/ref/' . $request->accountid,
        ];

        if (Schema::hasColumn('users', 'login_password_plain')) {
            $userData['login_password_plain'] = $request->login_password;
        }

        $third = User::create($userData);

        CryptoAccount::create(['user_id' => $third->id]);

        $parent->update(['accountid_third' => $request->accountid]);

        $this->sendAccountWelcomeEmail($third, $parent, $request);

        return redirect()->back()
            ->with('success', "Third account {$request->accountid} created successfully for {$parent->name}. Welcome email sent.");
    }

    // ─── Create fourth account form ──────────────────────────────────────────

    public function createFourthForm(Request $request)
    {
        $users = User::where('is_secondary', 0)
            ->select('id', 'name', 'email', 'accountid')
            ->orderBy('name')
            ->get();

        $lastAccountId = User::orderByDesc('id')->value('accountid');
        $nextAccountId = $lastAccountId ? (int)$lastAccountId + 1 : 10200;

        $preselect = null;
        if ($request->get('user_id')) {
            $preselect = User::find($request->get('user_id'));
        }

        return view('admin.fourth-account-requests.create', [
            'title'         => 'Create Fourth Account',
            'users'         => $users,
            'nextAccountId' => $nextAccountId,
            'preselect'     => $preselect,
        ]);
    }

    // ─── Store fourth account ─────────────────────────────────────────────────

    public function storeFourth(Request $request)
    {
        $request->validate([
            'parent_user_id' => 'required|exists:users,id',
            'accountid'      => 'required|unique:users,accountid',
            'email'          => 'required|email|unique:users,email',
            'login_password' => 'required|min:6',
        ]);

        $parent   = User::findOrFail($request->parent_user_id);
        $settings = Settings::find(1);

        $userData = [
            'name'           => $parent->name,
            'email'          => $request->email,
            'username'       => $request->email,
            'phone'          => $parent->phone,
            'country'        => $parent->country,
            'password'       => Hash::make($request->login_password),
            'accountid'      => $request->accountid,
            'is_secondary'   => 3,
            'parent_user_id' => $parent->id,
            'status'         => 'active',
            'ref_link'       => $settings->site_address . '/ref/' . $request->accountid,
        ];

        if (Schema::hasColumn('users', 'login_password_plain')) {
            $userData['login_password_plain'] = $request->login_password;
        }

        $fourth = User::create($userData);

        CryptoAccount::create(['user_id' => $fourth->id]);

        $parent->update(['accountid_fourth' => $request->accountid]);

        $this->sendAccountWelcomeEmail($fourth, $parent, $request);

        return redirect()->back()
            ->with('success', "Fourth account {$request->accountid} created successfully for {$parent->name}. Welcome email sent.");
    }

    /**
     * Send welcome email with investor & master password
     * to the user's account email and support emails.
     */
    protected function sendAccountWelcomeEmail(User $subUser, User $parent, Request $request)
    {
        $parentAccount = DB::table('accounts')->where('account_id', $parent->accountid)->first();

        $investorPassword = !empty($request->investor_password) && $request->investor_password !== 'Not found in accounts table'
            ? $request->investor_password
            : ($parentAccount->investor_password ?? 'N/A');

        $masterPassword = !empty($request->master_password) && $request->master_password !== 'Not found in accounts table'
            ? $request->master_password
            : ($parentAccount->master_password ?? 'N/A');

        $accountData = (object) [
            'investor_password' => $investorPassword,
            'master_password'   => $masterPassword,
        ];

        $recipients = array_unique(array_filter([
            $subUser->email,
            'support@majestyfx.com',
            'support@majestiglobal.com',
        ]));

        foreach ($recipients as $recipient) {
            try {
                Mail::to($recipient)->send(new WelcomeEmail($subUser, $accountData));
            } catch (\Exception $e) {
                Log::error("Failed to send welcome email for account {$subUser->accountid} to {$recipient}: " . $e->getMessage());
            }
        }
    }
}
