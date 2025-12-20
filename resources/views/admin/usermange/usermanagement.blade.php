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

{{-- TOP Overview --}}
<div class="wrapper">
<div class="card-row">
        <div class="metric-card">
            <div class="metric-label">Total Users</div>
            <div class="metric-value">{{ $total ?? '1250' }}</div>
        </div>

        <div class="metric-card">
            <div class="metric-label">Admins</div>
            <div class="metric-value">{{ $admin ?? '8' }}</div>
        </div>

        <div class="metric-card">
            <div class="metric-label">Users</div>
            <div class="metric-value">{{ $customer ?? '15' }}</div>
        </div>

    </div>

{{-- Search + Filter --}}
<form method="GET" class="search-filter-box">
    <input type="text" name="search"
           value="{{ request('search') }}" placeholder="Search user name..."
           class="input-dark" style="width:240px;">

    <select name="role" class="select-dark">
        <option value="">All Roles</option>
        <option value="Admin"   
        {{ request('role')=='Admin'?'selected':'' }}
        >Admin</option>
        <option value="Customer"    
        {{ request('role')=='Customer'?'selected':'' }}
        >Customer</option>
    </select>

    <button class="btn-orange">Filter</button>
</form>

{{-- Add User --}}
<a href="
{{ route('admin.employee.create') }}
  " class="btn-add">+ Add employee</a>
 <a href="
{{ route('admin.customer.create') }}
  " class="btn-add">+ Add customer</a>

{{-- Table --}}
<div class="table-wrapper">
<table class="table-dark">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Registered</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
    @forelse($users as $user)
        <tr>
            <td>
                {{ $user->id }}
            </td>
            <td>
                {{ $user->name }}
            </td>
            <td>
                {{ $user->email }}
            </td>

            <td>
                <span class="badge-role 
                {{ $user->role == 'admin' ? 'admin':'user' }}
                 ">
                    {{ ucfirst($user->role) }}
                </span>
            </td>

            <td>
                {{ $user->created_at->format('Y-m-d') }}
            </td>

            <td>
                {{-- Edit link depending on role --}}
            @if($user->role == 'admin')
            <a href="{{ route('users.employee.edit', $user->id) }}" class="action-btn btn-edit">✏️</a>
            @else
            <a href="{{ route('users.customer.edit', $user->id) }}" class="action-btn btn-edit">✏️</a>
            @endif
                <form action="
                {{ route('users.delete', $user->id) }}
                 " method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button class="action-btn btn-delete" 
                            onclick="return confirm('Delete this user?')">🗑️</button>
                </form>
            </td>
        </tr>
    @empty
        <tr><td colspan="6" style="text-align:center;color:#888;">No users found</td></tr>
    @endforelse
    </tbody>
</table>
</div>

<div style="margin-top:20px;">
    {{-- {{ $users->links() }} --}}
</div>
</div>