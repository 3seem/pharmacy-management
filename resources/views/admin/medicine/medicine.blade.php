@extends('layouts.testlayout')
   {{-- Use the layout file you sent --}}

                    
                     @php
                        $categories = [
                            'admin.dashboard' => ['text' => 'Admin Dashboard', 'route' => 'admin.dashboard'],
                            'usermanagement.index' => ['text' => 'User Management', 'route' => 'usermanagement.index'],
                            'medicine.index' => ['text' => 'Medicine', 'route' => 'medicine.index'],
                            'suppliers.index' => ['text' => 'Suppliers', 'route' => 'suppliers.index'],
                            'sales.index' => ['text' => 'Sales', 'route' => 'sales.index'],
                            'orders.index' => ['text' => 'Orders', 'route' => 'orders.index'],
                        ];
                    @endphp
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
    background:#ff5c25;color:white;border-radius:6px;padding:10px 18px;
}
.btn-orange:hover{opacity:.85;}
.select-dark{
    background:#0f0f0f;border:1px solid #1c1c1c;color:#eee;
    padding:10px;border-radius:8px;
}
</style>
    <style>
/* ───────── Pharmacy dashboard — clean dark data table ───────── */
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
}
.table tr:hover{background:#151515;}
.btn-green{
    background:#3498db;
    color:white;
    border-radius:6px;
    padding:6px 14px;
}.btn-green:hover{opacity:.5;}
.btn-orange{
    background:green;
    color:white;
    border-radius:6px;
    padding:6px 14px;
}
.btn-orange:hover{opacity:.5;}
.btn-red{background:#e53935;color:white;padding:6px 14px;border-radius:6px;}
.btn-red:hover{opacity:.75;}
.card-row{
    display:flex;
    gap:20px;
    margin-top:60px;
}
.metric-card{
    flex:1;
    background:#0d0d0d;
    border:1px solid #1c1c1c;
    padding:25px;
    border-radius:12px;
    color:white;
}
.metric-label{font-size:14px;color:#ff8c00;}
.metric-value{font-size:34px;font-weight:700;margin-top:8px;}
    </style>


{{-- Title under hero automatically --}}
<div class="wrapper">
    
    {{-- TOP METRIC CARDS --}}
    <div class="card-row">
        <div class="metric-card">
            <div class="metric-label">Total Stock</div>
            <div class="metric-value">{{ $totalStock ?? '1250' }}</div>
        </div>

        <div class="metric-card">
            <div class="metric-label">Low Stock Alerts</div>
            <div class="metric-value">{{ $lowStockCount ?? '8' }}</div>
        </div>

        <div class="metric-card">
            <div class="metric-label">Expiring Soon</div>
            <div class="metric-value">{{ $expiringSoonCount ?? '15' }}</div>
        </div>

        <div class="metric-card">
            <div class="metric-label">Medicines Available</div>
            <div class="metric-value">{{ $totalTypes ?? '180' }}</div>
        </div>
    </div>
<form method="GET" class="search-filter-box">

    <input type="text" name="search" value="{{ request('search') }}"
           placeholder="Search medicine..."
           class="input-dark" style="width:240px;">

    <select name="category" class="select-dark">
        <option value="">All Categories</option>
        @foreach($categories as $cat)
            <option value="
            {{-- {{ $cat }} --}}
            "
                {{-- {{ request('category')==$cat?'selected':'' }} --}}
                >
                {{-- {{ $cat }} --}}
            </option>
        @endforeach
    </select>

    <select name="stock" class="select-dark">
        <option value="">Any Stock</option>
        <option value="low"
         {{-- {{ request('stock')=='low'?'selected':'' }} --}}
         >Low Stock</option>
        <option value="available"
         {{-- {{ request('stock')=='available'?'selected':'' }} --}}
         >In Stock</option>
    </select>

    <button class="btn-orange">Filter</button>
</form>
{{-- {{dd($medicines)}} --}}
    {{-- Action Button --}}
    <div style="margin-top:35px;">
        <a href="
        {{ route('admin.medicine.add') }}
        " class="btn-orange">+ Add Medicine</a>
    </div>


    {{-- TABLE SECTION --}}
    <div class="table-container">
        <h2 style="color:white;margin-bottom:10px">Medicine Inventory</h2>

        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Stock</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th width="180px">Actions</th>
                </tr>
            </thead>

            <tbody>
            @forelse($medicines as $medicine)
                <tr>
                    <td>
                        {{ $medicine->Name }}
                    </td>
                    <td>
                        {{ $medicine->Category }}
                    </td>
                    <td>
                        {{ $medicine->Stock }}
                    </td>
                    <td>
                        {{ $medicine->Price }}
                    </td>
                    <td style="width:40px;  ">
                        <img src="{{ asset($medicine->image_url) }}"
                                                             class="img-fluid rounded"
                                                             alt="{{ $medicine->Name }}">
                    </td>
                    
                    <td>
                        {{-- <a href="
                        {{ route('medicine.restock',$medicine->id) }}
                         " class="btn-orange">+</a> --}}
                        <a href="
                        {{ route('admin.medicine.edit',$medicine->medicine_id) }}
                         " class="btn-green">✏️</a>
                        <form method="POST" action="
                        {{ route('admin.medicine.destroy',$medicine->medicine_id) }}
                         " style="display:inline">
                            @csrf @method('DELETE')
                            <button class="btn-red" onclick="return confirm('Delete item?')">🗑️</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6">No medicines yet</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

</div>

