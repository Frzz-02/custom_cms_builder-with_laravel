<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Page;
use App\Models\Setting;
use App\Models\LoginHistory;

class DashboardController extends Controller
{
    /**
     * Show the dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        $settings = Setting::first();

        // Get statistics
        $stats = [
            'total_users' => User::count(),
            'total_pages' => Page::count(),
            'active_pages' => Page::where('status', 'active')->count(),
            'draft_pages' => Page::where('status', 'draft')->count(),
        ];

        // Get login history (latest 10 records)
        $loginHistory = LoginHistory::with('user')
            ->orderBy('login_time', 'desc')
            ->limit(10)
            ->get();

        return view('backend.dashboard', compact('user', 'stats', 'loginHistory', 'settings'));
    }
}
