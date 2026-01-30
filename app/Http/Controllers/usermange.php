<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class usermange extends Controller
{
    //
    public function user(Request $request)
    {
        $total  = User::count();
        $customer   = User::where('role', '=', 'customer')->count();
        $admin   = User::where('role', '=', 'admin')->count();
        $role = User::select('role')->distinct()->pluck('role');

        $users   = User::query();

        if ($request->search) {
            $users->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->role && $request->role != "") {
            $users->where('role', $request->role);
        }

        $users = $users->get();   // or ->paginate(10)

        return view('admin.usermange.usermanagement', compact('users', 'total', 'customer', 'admin', 'role'));
    }

    public function deleteUser($id)
    {
        try {
            $user = User::findOrFail($id);

            if ($user->role === 'customer') {
                DB::statement('CALL sp_DeleteCustomer(?)', [$id]);
            } elseif ($user->role === 'admin') {
                DB::statement('CALL sp_DeleteEmployee(?)', [$id]);
            }

            return redirect()->back()->with('success', 'User deleted successfully');
        } catch (\Exception $e) {
            Log::error('Error deleting user: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to delete user: ' . $e->getMessage());
        }
    }

    public function createcust()
    {
        return view('admin.usermange.createcust');
    }

    public function createemp()
    {
        return view('admin.usermange.createemp');
    }

    public function storeCustomer(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email|unique:users,email|max:255',
            'password' => 'required|min:6',
            'DOB'     => 'nullable|date',
            'Phone'   => 'nullable|string|max:20',
            'Address' => 'nullable|string',
        ]);

        try {
            // Call stored procedure
            DB::statement("CALL sp_AddCustomer(?, ?, ?, ?)", [
                $request->name,
                $request->email,
                Hash::make($request->password),
                $request->DOB,
            ]);

            // Get the newly created user
            $user = User::where('email', $request->email)->first();

            if ($user) {
                // Auto-verify email for admin-created users
                $user->email_verified_at = Carbon::now();

                // Update Phone and Address
                $user->Phone = $request->Phone;
                $user->Address = $request->Address;

                $user->save();
            }

            return redirect()->route('admin.usermanagement')
                ->with('success', 'Customer added and verified successfully!');
        } catch (\Exception $e) {
            Log::error('Error adding customer: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to add customer: ' . $e->getMessage());
        }
    }

    public function storeEmployee(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email|unique:users,email|max:255',
            'password' => 'required|min:6',
            'Salary'  => 'required|numeric|min:0.01',
            'Hire_Date' => 'required|date',
            'employment_status' => 'required|in:Active,On Leave,Terminated',
            'Phone'   => 'nullable|string|max:20',
            'Address' => 'nullable|string',
        ]);

        try {
            // Call stored procedure
            DB::statement("CALL sp_AddEmployee(?, ?, ?, ?, ?, ?)", [
                $request->name,
                $request->email,
                Hash::make($request->password),
                $request->Salary,
                $request->Hire_Date,
                $request->employment_status,
            ]);

            // Get the newly created user
            $user = User::where('email', $request->email)->first();

            if ($user) {
                // Auto-verify email for admin-created users
                $user->email_verified_at = Carbon::now();

                // Update Phone and Address
                $user->Phone = $request->Phone;
                $user->Address = $request->Address;

                $user->save();
            }

            return redirect()->route('admin.usermanagement')
                ->with('success', 'Employee added and verified successfully!');
        } catch (\Exception $e) {
            Log::error('Error adding employee: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to add employee: ' . $e->getMessage());
        }
    }

    public function editCustomer($id)
    {
        $customer = DB::table('users')
            ->join('customers', 'users.id', '=', 'customers.id')
            ->select('users.*', 'customers.DOB')
            ->where('users.id', $id)
            ->first();

        if (!$customer) {
            return redirect()->route('admin.usermanagement')->with('error', 'Customer not found');
        }

        return view('admin.usermange.editcust', compact('customer'));
    }

    public function editEmployee($id)
    {
        $employee = DB::table('users')
            ->join('employees', 'users.id', '=', 'employees.id')
            ->select('users.*', 'employees.Salary', 'employees.Hire_Date', 'employees.employment_status')
            ->where('users.id', $id)
            ->first();

        if (!$employee) {
            return redirect()->route('admin.usermanagement')->with('error', 'Employee not found');
        }

        return view('admin.usermange.editemp', compact('employee'));
    }

    public function updateCustomer(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'dob'  => 'nullable|date',
            'password' => 'nullable|min:6',
            'Phone'   => 'nullable|string|max:20',
            'Address' => 'nullable|string',
            'verify_email' => 'nullable|boolean',
        ]);

        try {
            // Hash password only if provided
            $password = $request->password ? Hash::make($request->password) : null;

            // Call stored procedure
            DB::statement("CALL sp_UpdateCustomer(?, ?, ?, ?, ?)", [
                $id,
                $request->name,
                $request->email,
                $request->dob,
                $password
            ]);

            // Update additional fields and email verification
            $user = User::find($id);
            if ($user) {
                // Update Phone and Address
                $user->Phone = $request->Phone;
                $user->Address = $request->Address;

                // Handle email verification status
                if ($request->has('verify_email') && $request->verify_email) {
                    // Mark as verified
                    if (!$user->email_verified_at) {
                        $user->email_verified_at = Carbon::now();
                    }
                } else {
                    // Remove verification
                    $user->email_verified_at = null;
                }

                $user->save();
            }

            return redirect()->route('admin.usermanagement')
                ->with('success', 'Customer updated successfully!');
        } catch (\Exception $e) {
            Log::error('Error updating customer: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to update customer: ' . $e->getMessage());
        }
    }

    public function updateEmployee(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'salary' => 'required|numeric|min:0.01',
            'employment_status' => 'required|in:Active,On Leave,Terminated',
            'password' => 'nullable|min:6',
            'Phone'   => 'nullable|string|max:20',
            'Address' => 'nullable|string',
            'verify_email' => 'nullable|boolean',
        ]);

        try {
            // Hash password only if provided
            $password = $request->password ? Hash::make($request->password) : null;

            // Call stored procedure
            DB::statement("CALL sp_UpdateEmployee(?, ?, ?, ?, ?, ?)", [
                $id,                              // p_id (BIGINT)
                $request->name,                   // p_name
                $request->email,                  // p_email
                $request->employment_status,      // p_status (ENUM)
                (float) $request->salary,         // p_salary
                $password                         // p_password
            ]);

            // Update additional fields and email verification
            $user = User::find($id);
            if ($user) {
                // Update Phone and Address
                $user->Phone = $request->Phone;
                $user->Address = $request->Address;

                // Handle email verification status
                if ($request->has('verify_email') && $request->verify_email) {
                    // Mark as verified
                    if (!$user->email_verified_at) {
                        $user->email_verified_at = Carbon::now();
                    }
                } else {
                    // Remove verification
                    $user->email_verified_at = null;
                }

                $user->save();
            }

            return redirect()->route('admin.usermanagement')
                ->with('success', 'Employee updated successfully!');
        } catch (\Exception $e) {
            Log::error('Error updating employee: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to update employee: ' . $e->getMessage());
        }
    }
}
