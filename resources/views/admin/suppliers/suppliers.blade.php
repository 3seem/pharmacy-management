@extends('layouts.testlayout')    

                    
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
.table-wrapper{
    margin-top:40px;border:1px solid #1a1a1a;border-radius:10px;overflow:hidden;
}
.table-dark{
    width:100%;border-collapse:collapse;font-size:15px;color:#ddd;
}
.table-dark thead{background:#0d0d0d;}
.table-dark th,.table-dark td{
    padding:12px 14px;border-bottom:1px solid #1c1c1c;text-align:left;
}
.table-dark tbody tr:hover{background:#151515;}
.action-btn{
    padding:5px 12px;border-radius:6px;font-size:14px;
}
.btn-edit{background:#3498db;color:white;}
.btn-delete{background:#e74c3c;color:white;}
.btn-add{
    background:#ff5c25;color:white;padding:10px 18px;border-radius:6px;
    margin-bottom:20px;display:inline-block;
}
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
<div class="wrapper">
<div class="card-row">
        <div class="metric-card">
            <div class="metric-label">Total Suppliers</div>
            <div class="metric-value">{{ $total ?? '1250' }}</div>
        </div>

        <div class="metric-card">
            <div class="metric-label">Active Suppliers</div>
            <div class="metric-value">{{ $active ?? '8' }}</div>
        </div>

        <div class="metric-card">
            <div class="metric-label">Inactive Suppliers</div>
            <div class="metric-value">{{ $not_active ?? '15' }}</div>
        </div>

    </div>
{{-- Search + Filter --}}
<form method="GET" class="search-filter-box">
    <input type="text" name="search" value="
    {{ request('search') }} 
     "
        placeholder="Search supplier name..."
        class="input-dark" style="width:240px;">

    <select name="city" class="select-dark">
        <option value="all">All Countries</option>
        @foreach($city as $c)
            <option value="
            {{ $c }}
             "  
             {{ request('city')==$c?'selected':'' }}
             >
                {{ $c }}
            </option>
        @endforeach
    </select>

    <button class="btn-orange">Search</button>
</form>


{{-- Add Supplier --}}
<a href="
{{ route('admin.suppliers.create') }}
" class="btn-add">+ Add Supplier</a>


<div class="table-wrapper">
<table class="table-dark">
    <thead>
        <tr>
            <th>Supplier Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Person</th>
            <th>Address</th>
            <th>city</th>
            <th>is_active</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($suppliers as $supplier)
        <tr>
            <td>
                {{ $supplier->Supplier_Name }}
            </td>
            <td>
                {{ $supplier->email }}
            </td>
            <td>
                {{ $supplier->Contact_Phone }}
            </td>
            <td>
                {{ $supplier->Contact_Person }}
            </td>
            <td>
                {{ $supplier->address }}
            </td>
            <td>
                {{ $supplier->city }}
            </td>
            <td>
                {{ $supplier->is_active }}
            </td>
            <td>
                <a href="
                {{ route('admin.suppliers.edit',$supplier->Supplier_ID) }}
                 " class="action-btn btn-edit">✏️</a>
                <form action="
                {{ route('admin.suppliers.destroy',$supplier->Supplier_ID) }}
                 "
                      method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button class="action-btn btn-delete"
                        onclick="return confirm('Delete supplier?')">🗑️</button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="6" style="text-align:center;color:#777;">No suppliers found</td></tr>
        @endforelse
    </tbody>
</table>
</div>

<div style="margin-top:20px;">
    {{-- {{ $suppliers->links() }} Pagination --}}
</div>
</div>

