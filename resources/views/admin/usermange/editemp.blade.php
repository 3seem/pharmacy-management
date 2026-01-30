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
.verification-status{
    padding:10px;
    border-radius:6px;
    margin-bottom:20px;
    display:flex;
    align-items:center;
    gap:10px;
}
.verified{
    background:#1b5e20;
    border:1px solid #2e7d32;
}
.not-verified{
    background:#b71c1c;
    border:1px solid #c62828;
}
.checkbox-group{
    display:flex;
    align-items:center;
    gap:10px;
}
.checkbox-group input[type="checkbox"]{
    width:auto;
    margin:0;
}
</style>
<br><br><br><br><br><br>
<div class="form-box">
    <h2>Edit Employee</h2>

    @if (session('error'))
    <div style="background:#d32f2f;color:white;padding:10px;border-radius:5px;margin-bottom:15px;">
        {{ session('error') }}
    </div>
    @endif

    @if ($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
                <li style="color:red">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Email Verification Status -->
    <div class="verification-status {{ $employee->email_verified_at ? 'verified' : 'not-verified' }}">
        @if($employee->email_verified_at)
            <span>✅</span>
            <div>
                <strong>Email Verified</strong><br>
                <small>Verified on {{ \Carbon\Carbon::parse($employee->email_verified_at)->format('M d, Y h:i A') }}</small>
            </div>
        @else
            <span>⚠️</span>
            <div>
                <strong>Email Not Verified</strong><br>
                <small>This employee has not verified their email address</small>
            </div>
        @endif
    </div>

    <form action="{{ route('users.employee.update', $employee->id) }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Employee Name <span style="color:red">*</span></label>
            <input type="text" name="name" value="{{ old('name', $employee->name) }}" required>
        </div>

        <div class="form-group">
            <label>Email <span style="color:red">*</span></label>
            <input type="email" name="email" value="{{ old('email', $employee->email) }}" required>
        </div>

        <div class="form-group">
            <label>Password (leave blank to keep current)</label>
            <input type="password" name="password" placeholder="Enter new password or leave blank" minlength="6">
            <small style="color:#999;font-size:13px;">Minimum 6 characters if changing password</small>
        </div>

        <div class="form-group">
            <label>Phone</label>
            <input type="text" name="Phone" value="{{ old('Phone', $employee->Phone) }}">
        </div>

        <div class="form-group">
            <label>Address</label>
            <textarea name="Address" rows="3">{{ old('Address', $employee->Address) }}</textarea>
        </div>

        <div class="form-group">
            <label>Salary <span style="color:red">*</span></label>
            <input type="number" step="0.01" min="0.01" name="salary" value="{{ old('salary', $employee->Salary) }}" required>
        </div>

        <div class="form-group">
            <label>Employment Status <span style="color:red">*</span></label>
            <select name="employment_status" required>
                <option value="Active" {{ old('employment_status', $employee->employment_status) == 'Active' ? 'selected' : '' }}>Active</option>
                <option value="On Leave" {{ old('employment_status', $employee->employment_status) == 'On Leave' ? 'selected' : '' }}>On Leave</option>
                <option value="Terminated" {{ old('employment_status', $employee->employment_status) == 'Terminated' ? 'selected' : '' }}>Terminated</option>
            </select>
        </div>

        <!-- Email Verification Control -->
        <div class="form-group">
            <div class="checkbox-group">
                <input type="checkbox" name="verify_email" id="verify_email" value="1" 
                    {{ old('verify_email', $employee->email_verified_at ? 1 : 0) ? 'checked' : '' }}>
                <label for="verify_email" style="margin:0;">
                    @if($employee->email_verified_at)
                        Email is verified
                    @else
                        Mark email as verified
                    @endif
                </label>
            </div>
            <small style="color:#999;font-size:13px;">
                @if($employee->email_verified_at)
                    Uncheck to remove verification status
                @else
                    Check to manually verify this employee's email
                @endif
            </small>
        </div>

        <button type="submit" class="btn-save">💾 Update Employee</button>
        <a href="{{ route('admin.usermanagement') }}" class="btn-cancel">Cancel</a>
    </form>
</div>