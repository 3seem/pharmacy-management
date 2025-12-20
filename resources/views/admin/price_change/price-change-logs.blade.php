@extends('layouts.testlayout')



{{-- ====================== STYLES ====================== --}}
<style>
.search-filter-box{display:flex;gap:15px;align-items:center;margin:30px 0;}
.input-dark{background:#0f0f0f;border:1px solid #1c1c1c;color:#eee;padding:10px 14px;border-radius:8px;}
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

.price-up{color:#2ecc71;font-weight:bold;}
.price-down{color:#e74c3c;font-weight:bold;}
</style>

<div class="wrapper">

{{-- ===================== STATS ===================== --}}
<div class="card-row">
    <div class="metric-card">
        <div class="metric-label">Total Price Updates</div>
        <div class="metric-value">{{ $totalChanges ?? 210 }}</div>
    </div>

    <div class="metric-card">
        <div class="metric-label">Today Changes</div>
        <div class="metric-value">{{ $todayChanges ?? 6 }}</div>
    </div>

    <div class="metric-card">
        <div class="metric-label">Last 7 Days</div>
        <div class="metric-value">{{ $weekChanges ?? 28 }}</div>
    </div>
</div>


{{-- ===================== SEARCH/FILTER ===================== --}}
<form method="GET" class="search-filter-box">
    <input type="text" name="search" class="input-dark" placeholder="Search medicine or user..." style="width:260px;" value="{{ request('search') }}">

    <select name="type" class="select-dark">
        <option value="">Change Type</option>
        <option value="increase">Increased</option>
        <option value="decrease">Decreased</option>
    </select>

    <input type="date" name="date" class="input-dark">

    <button class="btn-orange">Search</button>
</form>


{{-- ===================== TABLE ===================== --}}
<div class="table-wrapper">
<table class="table-dark">
    <thead>
        <tr>
            <th>ID</th>
            <th>Medicine</th>
            <th>Old</th>
            <th>New</th>
            <th>User</th>
            <th>Date</th>
        </tr>
    </thead>

    <tbody>
    @foreach($price_change_logs as $log)
        <tr>
            <td>{{ $log->log_id }}</td>
            <td>{{ $log->medicine->Name ?? 'Unknown' }}</td>
            <td class="text-danger">{{ $log->old_price }}</td>
            <td class="text-success">{{ $log->new_price }}</td>
            <td>{{ $log->user->name ?? 'System' }}</td>
            <td>{{ $log->changed_at }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</div>

<div style="margin-top:20px;">
    {{-- Pagination → {{ $priceLogs->links() }} --}}
</div>

</div>
