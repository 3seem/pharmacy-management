        @extends('layouts.testlayout')



        {{-- ====================== STYLE ====================== --}}
        <style>
        .search-filter-box{display:flex;gap:15px;align-items:center;margin:30px 0;}
        .input-dark{background:#0f0f0f;border:1px solid #1c1c1c;color:#eee;padding:10px 14px;border-radius:8px;outline:none;}
        .input-dark::placeholder{color:#777;}
        .select-dark{background:#0f0f0f;border:1px solid #1c1c1c;color:#eee;padding:10px;border-radius:8px;}
        .btn-orange{background:#ff5c25;color:white;border-radius:6px;padding:10px 18px;}
        .btn-orange:hover{opacity:.85;}

        .table-wrapper{margin-top:40px;border:1px solid #1a1a1a;border-radius:10px;overflow:hidden;}
        .table-dark{width:100%;border-collapse:collapse;font-size:15px;color:#ddd;}
        .table-dark thead{background:#0d0d0d;}
        .table-dark th,.table-dark td{padding:12px 14px;border-bottom:1px solid #1c1c1c;text-align:left;}
        .table-dark tbody tr:hover{background:#151515;}

        .card-row{display:flex;gap:20px;margin-top:60px;}
        .metric-card{flex:1;background:#0d0d0d;border:1px solid #1c1c1c;padding:25px;border-radius:12px;color:white;}
        .metric-label{font-size:14px;color:#ff8c00;}
        .metric-value{font-size:34px;font-weight:700;margin-top:8px;}
        </style>

        <div class="wrapper">

        {{-- =================== STAT CARDS =================== --}}
        <div class="card-row">
            <div class="metric-card">
                <div class="metric-label">Total Logs</div>
                <div class="metric-value">{{ $totalLogs ?? 512 }}</div>
            </div>

            <div class="metric-card">
                <div class="metric-label">Today's Logs</div>
                <div class="metric-value">{{ $todayLogs ?? 42 }}</div>
            </div>

            <div class="metric-card">
                <div class="metric-label">Last 7 Days</div>
                <div class="metric-value">{{ $weekLogs ?? 129 }}</div>
            </div>
        </div>


        {{-- =================== SEARCH / FILTER =================== --}}
        <form method="GET" class="search-filter-box">
            <input type="text" name="search" class="input-dark" placeholder="Search by admin or action..." value="{{ request('search') }}" style="width:260px;">

           <select name="action" class="select-dark">
    <option value="">All Actions</option>
    <option value="login" {{ request('action')=='login' ? 'selected' : '' }}>Login</option>
    <option value="logout" {{ request('action')=='logout' ? 'selected' : '' }}>Logout</option>
    <option value="create" {{ request('action')=='create' ? 'selected' : '' }}>Create</option>
    <option value="update" {{ request('action')=='update' ? 'selected' : '' }}>Update</option>
    <option value="delete" {{ request('action')=='delete' ? 'selected' : '' }}>Delete</option>
</select>

<input type="date" name="date" class="input-dark" value="{{ request('date') }}">


            <button class="btn-orange">Search</button>
        </form>


        {{-- =================== LOG TABLE =================== --}}
        <div class="table-wrapper">
        <table class="table-dark">
        <thead>
                    <tr>
                        <th>Admin</th>
                        <th>Table</th>
                        <th>Action</th>
                        <th>Old Values</th>
                        <th>New Values</th>
                        <th>Changed By</th>
                        <th>Date</th>
                        <th>Description</th>
                    </tr>
                </thead>

                <tbody>
                @foreach($audit_logs as $log)
                    <tr>
                        
                        <td>{{ $log->user->name ?? 'System' }}</td>
                        <td>{{ $log->table_name }}</td>

                        <td>
                            <span class="badge 
                                @if($log->action == 'INSERT') bg-success 
                                @elseif($log->action == 'UPDATE') bg-warning 
                                @elseif($log->action == 'DELETE') bg-danger 
                                @else bg-secondary @endif">
                                {{ $log->action }}
                            </span>
                        </td>

                        {{-- decode JSON --}}
                        <td>
                            @if($log->old_values)
                                <pre>{{ json_encode(json_decode($log->old_values), JSON_PRETTY_PRINT) }}</pre>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>

                        <td>
                            @if($log->new_values)
                                <pre>{{ json_encode(json_decode($log->new_values), JSON_PRETTY_PRINT) }}</pre>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>

                        <td>{{ $log->changed_by ?? 'System' }}</td>
                        <td>{{ $log->changed_at }}</td>
                        <td>{{ $log->description }}</td>
                    </tr>
                @endforeach
                </tbody>
        </table>
        </div>

        <div style="margin-top:20px;">
            {{-- Pagination If Connected:  {{ $logs->links() }} --}}
        </div>

        </div>
