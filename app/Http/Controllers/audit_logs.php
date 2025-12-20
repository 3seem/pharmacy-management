<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\audit_log;
use Carbon\Carbon;

class audit_logs extends Controller
{
    //
    public function audit()
    {
        $audit_logs = audit_log::with('user')->orderBy('audit_id', 'desc')
            ->get();

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
