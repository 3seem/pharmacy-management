<?php

namespace App\Http\Controllers;

use App\Models\audit_log;
use App\Models\medicine;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $totalSalesToday = Order::whereDate('created_at', now())->sum('Total_amount');
        $lowStockItems = medicine::whereColumn('Stock', '<=', 'low_stock_threshold')->count();
        $activeUsers = User::where('is_active', 1)->count();
        $recentActivities = audit_log::latest()->take(5)->get();

        return view('admin.dashboard.admin-dashboard', compact('totalSalesToday', 'lowStockItems', 'activeUsers', 'recentActivities'))
            ->with('pageTitle', 'Admin Dashboard');
    }
}
