@extends('layouts.testlayout')    {{-- same layout you provided --}}
                    
<style>
.search-filter-box{
    display:flex;gap:15px;align-items:center;margin:30px 0;
}
.input-dark{
    background:#0f0f0f;border:1px solid #1c1c1c;color:#eee;
    padding:10px 14px;border-radius:8px;outline:none;
}
.input-dark::placeholder{color:#777;}
.btn-orange{
    background:#3498db;color:white;border-radius:6px;padding:10px 18px;
}
.btn-orange:hover{opacity:.85;}
.select-dark{
    background:#0f0f0f;border:1px solid #1c1c1c;color:#eee;
    padding:10px;border-radius:8px;
}
</style>

<style>
/* █████ Orders Table UI theme █████ */
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
    font-weight:600;
    letter-spacing:.5px;
    border-bottom:1px solid #222;
}
.table td{
    color:#dcdcdc;
    padding:12px;
    border-bottom:1px solid #1a1a1a;
    width : 150px;
}
.table tr:hover{background:#151515;}

.btn-orange{
    background:green;
    color:white;border-radius:6px;padding:6px 14px;
    height: 35px;
}
.btn-orange:hover{opacity:.5;}
.btn-red{background:#e53935;color:white;padding:6px 14px;border-radius:6px;}
.btn-red:hover{opacity:.5;}

.card-row{display:flex;gap:20px;margin-top:60px;}
.metric-card{
    flex:1;background:#0d0d0d;border:1px solid #1c1c1c;padding:25px;
    border-radius:12px;color:white;
}
.metric-label{font-size:14px;color:#ff8c00;}
.metric-value{font-size:34px;font-weight:700;margin-top:8px;}
</style>
{{-- {{dd($orders)}} --}}
<div class="wrapper">

    <!-- Metrics Summary -->
    <div class="card-row">
        <div class="metric-card">
            <div class="metric-label">Total Orders</div>
            <div class="metric-value">{{ $total_orders ?? '412' }}</div>
        </div>

        <div class="metric-card">
            <div class="metric-label">Pending Orders</div>
            <div class="metric-value">{{ $pending ?? '23' }}</div>
        </div>

        <div class="metric-card">
            <div class="metric-label">Completed Orders</div>
            <div class="metric-value">{{ $Completed ?? '350' }}</div>
        </div>

        <div class="metric-card">
            <div class="metric-label">Total_amount</div>
            <div class="metric-value">${{ $Total_amount ?? '18,900' }}</div>
        </div>
    </div>
<!-- Search & Filters -->
<form method="GET" class="search-filter-box">
    
    <input type="text" name="search" value="{{ request('search') }}"
           placeholder="Search customer name"
           class="input-dark" style="width:240px;">

    <select name="status" class="select-dark">
        <option value="">All Status</option>
        <option value="pending"  
        {{ request('status')=='pending'?'selected':'' }}
        >Pending</option>
        <option value="completed" 
        {{ request('status')=='completed'?'selected':'' }}
        >Completed</option>
        <option value="cancelled" 
        {{ request('status')=='cancelled'?'selected':'' }}
        >Cancelled</option>
    </select>

    <button class="btn-orange">Search</button>
</form>


    <!-- Button -->
    <div style="margin-top:35px;">
        <a href="
        {{ route('orders.create') }}
         " class="btn-orange">+ Create Order</a>
    </div>


    <!-- Orders Table -->
    <div class="table-container">
        <h2 style="color:white;margin-bottom:10px">Orders List</h2>

        <table class="table">
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Employee</th>
                    <th>Total amount</th>
                    <th>discount amount</th>
                    <th>Tax amount</th>
                    <th>delivery_type</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>updated_at</th>
                    <th width="140px">Actions</th>
                </tr>
            </thead>

            <tbody>
            @forelse($orders as $order)
                <tr>
                    <td>
                        {{ $order->customer->name?? ''}}
                    </td>
                    <td>
                        {{ $order->employee->name??'' }}
                         </td>
                    <td>$
                        {{ number_format($order->Total_amount,2) }}
                    </td>
                    <td>$
                        {{ number_format($order->discount_amount,2) }}
                    </td>
                    <td>$
                        {{ number_format($order->tax_amount,2) }}
                    </td>
                    <td>
                        {{$order->delivery_type}}
                    </td>
                    <td>
                        @if(
                            $order->Status == 'Pending'
                            )
                            <span style="color:#ff8c00;">● Pending</span>
                        @elseif(
                        $order->Status == 'Completed'
                        )
                            <span style="color:#4caf50;">● Completed</span>
                        @else
                            <span style="color:#999;">● Rejected</span>
                        @endif
                    </td>
                    <td>
                        {{ $order->created_at->format('Y-m-d') }}
                    </td>
                    <td>
                        {{ $order->updated_at->format('Y-m-d') }}
                    </td>

                    <td>
                        <a href="
                            {{ route('orders.edit', $order->Order_ID) }}    
                          " class="btn-orange">🔍</a>

                           @if($order->Status == 'Pending')
        <form action="{{ route('orders.complete', $order->Order_ID) }}" method="POST" style="display:inline;">
            @csrf
            <button class="btn-orange" onclick="return confirm('Mark this order as Completed?')">✅ </button>
        </form>
    @endif
                        <form action="
                        {{ route('orders.destroy', $order->Order_ID) }}
                         " method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button class="btn-red" onclick="return confirm('Delete this order?')">🗑️</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7">No orders found</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

</div>

