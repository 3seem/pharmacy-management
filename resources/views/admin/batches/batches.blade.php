@extends('layouts.testlayout')

{{-- ===================== Styles ===================== --}}
<style>
.search-filter-box{
    display:flex;gap:15px;align-items:center;margin:30px 0;
}
.input-dark{
    background:#0f0f0f;border:1px solid #1c1c1c;color:#eee;
    padding:10px 14px;border-radius:8px;outline:none;
}
.input-dark::placeholder{color:#777;}
.select-dark{
    background:#0f0f0f;border:1px solid #1c1c1c;color:#eee;
    padding:10px;border-radius:8px;
}
.btn-green{
    background:#2ecc71;color:white;border-radius:6px;
    padding:8px 16px;
}
.btn-red{
    background:#e53935;color:white;border-radius:6px;
    padding:8px 16px;
}
.btn-green:hover,.btn-red:hover{opacity:.8;}
</style>

<style>
.table-container{
    margin-top:40px;
    background:#0a0a0a;
    border:1px solid #1c1c1c;
    border-radius:12px;
    padding:25px;
}
.table{
    width:100%;
    margin-top:15px;
    border-collapse:collapse;
}
.table th{
    background:#111;
    color:#fff;
    padding:14px;
    border-bottom:1px solid #222;
}
.table td{
    color:#ddd;
    padding:12px;
    border-bottom:1px solid #1a1a1a;
}
.table tr:hover{background:#151515;}
.card-row{display:flex;gap:20px;margin-top:50px;}
.metric-card{
    flex:1;background:#0d0d0d;border:1px solid #1c1c1c;
    padding:22px;border-radius:12px;color:white;
}
.metric-label{font-size:14px;color:#ff8c00;}
.metric-value{font-size:32px;font-weight:700;margin-top:8px;}
</style>

{{-- ===================== Content ===================== --}}
<div class="wrapper">

    {{-- ===================== Metrics ===================== --}}
    <div class="card-row">
        <div class="metric-card">
            <div class="metric-label">Total Batches</div>
            <div class="metric-value">{{ $total_batches }}</div>
        </div>

        <div class="metric-card">
            <div class="metric-label">Expired Batches</div>
            <div class="metric-value">{{ $expired_batches }}</div>
        </div>


        <div class="metric-card">
            <div class="metric-label">Total Stock</div>
            <div class="metric-value">{{ $total_stock }}</div>
        </div>
    </div>

    {{-- ===================== Search ===================== --}}
    <form method="GET" class="search-filter-box">
        <input type="text" name="search"
               value="{{ request('search') }}"
               placeholder="Search batch number"
               class="input-dark" style="width:260px;">

        <select name="expiry" class="select-dark">
            <option value="">All</option>
            <option value="expired" {{ request('expiry')=='expired'?'selected':'' }}>Expired</option>
            <option value="valid" {{ request('expiry')=='valid'?'selected':'' }}>Valid</option>
        </select>

        <button class="btn-green">Search</button>
    </form>

    {{-- ===================== Button ===================== --}}
    <div style="margin-top:30px;">
        <a href="
        {{ route('admin.batches.add') }}
        " class="btn-green">+ Add Batch</a>
    </div>

    {{-- ===================== Table ===================== --}}
    <div class="table-container">
        <h2 style="color:white;margin-bottom:10px">Batches List</h2>

        <table class="table">
            <thead>
                <tr>
                    <th>Batch #</th>
                    <th>Medicine</th>
                    <th>MFG Date</th>
                    <th>EXP Date</th>
                    <th>Quantity</th>
                    <th>Current Stock</th>
                    <th>Purchase Price</th>
                    <th>Status</th>
                    <th width="140">Actions</th>
                </tr>
            </thead>
            <tbody>
            @forelse($batches as $batch)
                <tr>
                    <td>{{ $batch->batch_number }}</td>

                    <td>
                        {{ optional($batch->medicine)->Name ?? '—' }}
                    </td>

                    <td>{{ $batch->mfg_date }}</td>
                    <td>{{ $batch->exp_date }}</td>

                    <td>{{ $batch->quantity }}</td>
                    <td>{{ $batch->current_stock }}</td>

                    <td>${{ number_format($batch->purchase_price,2) }}</td>

                    <td>
                        @if($batch->exp_date < now()->toDateString())
                            <span style="color:#e53935;">● Expired</span>
                        @elseif($batch->current_stock <= 10)
                            <span style="color:#ff9800;">● Low Stock</span>
                        @else
                            <span style="color:#4caf50;">● Valid</span>
                        @endif
                    </td>

                    <td>

                        <form action="
                        {{ route('admin.batches.destroy', $batch->batch_number) }}
                         "
                              method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button class="btn-red"
                              onclick="return confirm('Delete batch?')">🗑️</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9">No batches found</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

</div>
