<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use Illuminate\Http\Request;
use App\Models\price_change_log;

class price_change_logs extends Controller
{
    //
    public function audit()
    {
        $totalChanges = price_change_log::count();               // All records
        $todayChanges = price_change_log::whereDate('created_at', today())->count();
        $weekChanges  = price_change_log::where('created_at', '>=', now()->subDays(7))->count();
        $price_change_logs = price_change_log::with('medicine', 'user')
            ->orderBy('log_id', 'desc')
            ->get();
        return view('admin.price_change.price-change-logs', compact('price_change_logs', 'totalChanges', 'todayChanges', 'weekChanges'));
    }
}
