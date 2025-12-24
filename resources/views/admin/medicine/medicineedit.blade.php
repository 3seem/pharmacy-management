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
.form-group textarea{height:80px;resize:none;}

.btn-save{
    background:#ff5c25;border:none;color:white;padding:10px 22px;
    border-radius:6px;font-size:15px;margin-top:10px;
}
.btn-cancel{
    background:#444;border:none;color:white;padding:10px 22px;
    border-radius:6px;font-size:15px;margin-left:8px;
}
</style>
<br><br><br><br><br><br><br><br>
<div class="form-box">
    <h2>Edit Medicine</h2>
    @if ($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
                <li style="color:red">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <form action="
    {{ route('admin.medicine.update', $medicine->medicine_id) }}
     "method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Medicine Name</label>
            <input type="text" name="Name" value="{{ $medicine->Name }}" required>
        </div>

        <div class="form-group">
            <label>Category</label>
            <input type="text" name="Category" value="{{ $medicine->Category }}" required>
        </div>

        

        <div class="form-group">
            <label>Price (EGP)</label>
            <input type="number" step="0.01" name="Price" value="{{ $medicine->Price }}" required>
        </div>

        <div class="form-group">
            <label>Stock Quantity</label>
            <input type="number" name="Stock" value="{{ $medicine->Stock }}" required>
        </div>
        <div class="form-group">
            <input type="file" name="image_url">
        </div>
        


        <div class="form-group">
            <label>Description</label>
            <textarea name="Description">{{ $medicine->Description }}</textarea>
        </div>
        <div class="form-group">
            <label>Low Stock Threshold</label>
            <input type="number" name="low_stock_threshold" value="{{ $medicine->low_stock_threshold }}">
        </div>
        <div class="form-group">
            <select name="dosage_form">
                <option {{ $medicine->dosage_form=='Tablet'?'selected':'' }}>Tablet</option>
                <option {{ $medicine->dosage_form=='Capsule'?'selected':'' }}>Capsule</option>
                <option {{ $medicine->dosage_form=='Syrup'?'selected':'' }}>Syrup</option>
                <option {{ $medicine->dosage_form=='Injection'?'selected':'' }}>Injection</option>
            </select>
        </div>
        
    
        <div class="form-group">
            <label>strength</label>
            <input type="text" name="strength" value="{{ $medicine->strength }}">
        </div>
        <div class="form-group">
            <select name="is_active">
                <option value="1" {{ $medicine->is_active ? 'selected':'' }}>Active</option>
                <option value="0" {{ !$medicine->is_active ? 'selected':'' }}>Inactive</option>
            </select>
        </div>
    


        <button class="btn-save">💾 Save Changes</button>
        <a href="{{ route('admin.medicine') }}" class="btn-cancel">Cancel</a>
    </form>
</div>

