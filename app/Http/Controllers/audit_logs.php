<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\audit_log;
use Carbon\Carbon;

class audit_logs extends Controller
{
    //
    public function audit(Request $request)
    {
        // Filters
        $search = $request->query('search');
        $action = $request->query('action');
        $date   = $request->query('date');

        // Base query
        $query = audit_log::with('user')->orderBy('audit_id', 'desc');

        if ($search) {
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        if ($action) {
            $query->where('action', strtoupper($action));
        }

        if ($date) {
            $query->whereDate('changed_at', $date);
        }

        $audit_logs = $query->get();

        // Metrics
        $totalLogs  = audit_log::count();
        $todayLogs  = audit_log::whereDate('changed_at', Carbon::today())->count();
        $weekLogs   = audit_log::where('changed_at', '>=', Carbon::now()->subDays(7))->count();

        return view('admin.admin_logs.admin-logs', compact(
            'audit_logs',
            'totalLogs',
            'todayLogs',
            'weekLogs'
        ));
    }
}
