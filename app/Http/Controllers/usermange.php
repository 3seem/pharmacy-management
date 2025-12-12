<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
        $user = User::findOrFail($id);

        if ($user->role === 'customer') {
            DB::statement('CALL sp_DeleteCustomer(?)', [$id]);
        } elseif ($user->role === 'admin') {
            DB::statement('CALL sp_DeleteEmployee(?)', [$id]);
        } 

        return redirect()->back()->with('success', 'User deleted successfully');
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
            'name'    => 'required',
            'email'   => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'DOB'     => 'nullable|date',
        ]);

        DB::statement("CALL sp_AddCustomer(?, ?, ?, ?)", [
            $request->name,
            $request->email,
            bcrypt($request->password),
            $request->DOB,
        ]);

        return back()->with('success', 'Customer added successfully!');
    }
    public function storeEmployee(Request $request)
    {
        $request->validate([
            'name'    => 'required',
            'email'   => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'Salary'  => 'required|numeric',
            'Hire_Date' => 'required|date',
            'employment_status' => 'required',
        ]);

        DB::statement("CALL sp_AddEmployee(?, ?, ?, ?, ?, ?)", [
            $request->name,
            $request->email,
            bcrypt($request->password),
            $request->Salary,
            $request->Hire_Date,
            $request->employment_status,
        ]);

        return back()->with('success', 'Employee added successfully!');
    }
    
    public function editCustomer($id)
    {
        $customer = DB::table('users')
            ->join('customers', 'users.id', '=', 'customers.id')
            ->select('users.*', 'customers.DOB')
            ->where('users.id', $id)
            ->first();
        return view('admin.usermange.editcust', compact('customer'));
    }

    public function updateCustomer(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'dob'  => 'required|date',
            'password' => 'nullable|min:6'
        ]);

        $password = $request->password ? bcrypt($request->password) : null;

        DB::statement("CALL sp_UpdateCustomer(?, ?, ?, ?, ?)", [
            $id,
            $request->name,
            $request->email,
            $request->dob,
            $password
        ]);

        return redirect()->route('admin.usermange.index')->with('success', 'Customer updated successfully!');
    }

    public function editEmployee($id)
    {
        $employee = DB::table('users')
            ->join('employees', 'users.id', '=', 'employees.id')
            ->select('users.*', 'employees.Salary', 'employees.Hire_Date', 'employees.employment_status')
            ->where('users.id', $id)
            ->first();
        return view('admin.usermange.editemp', compact('employee'));
    }

    public function updateEmployee(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'Salary' => 'required|numeric',
            'Hire_Date' => 'required|date',
            'employment_status' => 'required',
            'password' => 'nullable|min:6'
        ]);

        $password = $request->password ? bcrypt($request->password) : null;

        DB::statement("CALL sp_UpdateEmployee(?, ?, ?, ?, ?)", [
            $id,
            $request->name,
            $request->email,
            $request->Salary,
            $request->employment_status
        ]);
        if ($request->password) {
            DB::table('users')->where('id', $id)->update([
                'password' => Hash::make($request->password)
            ]);
        }



        return redirect()->route('admin.usermange.index')->with('success', 'Employee updated successfully!');
    }
}
