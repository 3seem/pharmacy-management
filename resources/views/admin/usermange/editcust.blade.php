@extends('layouts.testlayout')

<div class="form-box">
    <h2>{{ isset($customer) ? 'Edit Customer' : 'Add Customer' }}</h2>
    <form action="{{ isset($customer) ? route('users.customer.update', $customer->id) : route('users.customer.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" value="{{ $customer->name ?? old('name') }}" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="{{ $customer->email ?? old('email') }}" required>
        </div>

        <div class="form-group">
            <label>Password {{ isset($customer) ? '(leave blank to keep current)' : '' }}</label>
            <input type="password" name="password" placeholder="{{ isset($customer) ? 'New password' : '' }}">
        </div>

        <div class="form-group">
            <label>DOB</label>
            <input type="date" name="dob" value="{{ $customer->DOB ?? old('dob') }}" required>
        </div>

        <button class="btn-save">{{ isset($customer) ? 'Update Customer' : 'Add Customer' }}</button>
        <a href="{{ route('admin.usermanagement') }}" class="btn-cancel">Cancel</a>
    </form>
</div>
