@extends('layouts.testlayout')

<style>
.form-box{
    background:#0d0d0d;border:1px solid #1b1b1b;border-radius:10px;
    padding:25px;margin-top:40px;width:70%;margin:auto;color:#ddd;
}
.form-box h2{text-align:center;margin-bottom:25px;color:#ff5c25;}

.form-group{margin-bottom:18px;}
.form-group label{display:block;margin-bottom:6px;font-size:15px;}
.form-group input,.form-group select,.form-group textarea{
    width:100%;padding:10px;background:#111;border:1px solid #333;
    border-radius:6px;color:#eee;font-size:15px;
}

.btn-save{
    background:#ff5c25;border:none;color:white;padding:10px 22px;
    border-radius:6px;font-size:15px;margin-top:10px;
}
.btn-cancel{
    background:#444;border:none;color:white;padding:10px 22px;
    border-radius:6px;font-size:15px;margin-left:8px;
}
</style>

<br><br><br><br><br><br>
<div class="form-box">
    <h2>Add New Customer</h2>

    @if ($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
                <li style="color:red">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.customers.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Customer Name</label>
            <input type="text" name="name" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" required>
        </div>
        <div class="form-group">
    <label>Password</label>
    <input type="password" name="password" required>
</div>

        <div class="form-group">
            <label>Phone</label>
            <input type="text" name="Phone">
        </div>

        <div class="form-group">
            <label>Address</label>
            <textarea name="Address"></textarea>
        </div>

        <div class="form-group">
            <label>Date of Birth</label>
            <input type="date" name="DOB">
        </div>

        <div class="form-group">
            <label>Status</label>
            <select name="is_active">
                <option value="1" selected>Active</option>
                <option value="0">Inactive</option>
            </select>
        </div>

        <button class="btn-save">➕ Add Customer</button>
        <a href="{{ route('admin.usermanagement') }}" class="btn-cancel">Cancel</a>

    </form>
</div>
