@extends('layouts.testlayout')

<style>
.form-box{
    background:#0d0d0d;border:1px solid #1c1c1c;
    border-radius:12px;padding:30px;
    width:60%;margin:40px auto;color:#eee;
}
.form-box h2{
    text-align:center;margin-bottom:25px;color:#2ecc71;
}
.form-group{margin-bottom:18px;}
label{display:block;margin-bottom:6px;color:#bbb;}
.input-dark, .select-dark{
    width:100%;background:#0f0f0f;border:1px solid #222;
    color:#eee;padding:10px;border-radius:8px;
}
.btn-green{
    background:#2ecc71;color:white;
    padding:10px 18px;border-radius:6px;
}
.btn-back{
    background:#555;color:white;
    padding:10px 18px;border-radius:6px;
}
</style>

<div class="form-box">
    <h2>Add New Batch</h2>
    @if ($errors->any())
    <div style="
        background:#2b0000;
        border:1px solid #ff5252;
        padding:15px;
        border-radius:8px;
        margin-bottom:20px;
        color:#ffb3b3;
    ">
        <strong>⚠️ Please fix the following errors:</strong>
        <ul style="margin:10px 0 0 20px;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <form action="{{ route('admin.batches.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Batch Number</label>
            <input type="text" name="batch_number"
                   class="input-dark" required>
        </div>

        <div class="form-group">
            <label>Medicine</label>
            <select name="medicine_id" class="select-dark">
                <option value="">-- Optional --</option>
                @foreach($medicines as $medicine)
                    <option value="{{ $medicine->medicine_id }}">
                        {{ $medicine->Name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Manufacture Date</label>
            <input type="date" name="mfg_date"
                   class="input-dark" required>
        </div>

        <div class="form-group">
            <label>Expiry Date</label>
            <input type="date" name="exp_date"
                   class="input-dark" required>
        </div>

        <div class="form-group">
            <label>Quantity</label>
            <input type="number" name="quantity"
                   class="input-dark" min="1" required>
        </div>

        <div class="form-group">
            <label>Purchase Price</label>
            <input type="number" step="0.01"
                   name="purchase_price"
                   class="input-dark" required>
        </div>

        <div style="display:flex;gap:15px;margin-top:25px;">
            <button class="btn-green">Save Batch</button>
            <a href="{{ route('admin.batches') }}" class="btn-back">Cancel</a>
        </div>
    </form>
</div>
