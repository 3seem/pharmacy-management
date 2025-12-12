<?php

namespace App\Http\Controllers;

use App\Models\supplier;
use Illuminate\Http\Request;

class Suplliers extends Controller
{
    //
    public function suppliers(Request $request)
    {
        $total  = supplier::count();
        $active   = supplier::where('is_active', '=', 1)->count();
        $not_active   = supplier::where('is_active', '=', 0)->count();
        $city = supplier::select('city')->distinct()->pluck('city');

        $suppliers = supplier::query();

        if ($request->search) {
            $suppliers->where('Supplier_Name', 'like', '%' . $request->search . '%');
        }

        if ($request->city && $request->city != "all") {
            $suppliers->where('city', $request->city);
        }

        $suppliers = $suppliers->get();   // or ->paginate(10)

        return view('admin.suppliers.suppliers', compact('suppliers', 'total', 'active', 'not_active', 'city'));
    }

    public function create()
    {
        return view('admin.suppliers.create');
    }

    // Store new supplier
    public function store(Request $request)
    {
        $request->validate([
            'Supplier_Name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'Contact_Phone' => 'nullable|string|max:30',
            'Contact_Person' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'is_active' => 'required|boolean',
        ]);

        supplier::create([
            'Supplier_Name'      => $request->Supplier_Name,
            'email'     => $request->email,
            'Contact_Phone'     => $request->Contact_Phone,
            'Contact_Person'     => $request->Contact_Person,
            'address'   => $request->address,
            'city'   => $request->city,
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('admin.suppliers')->with('success', 'Supplier added successfully.');
    }

    public function destroy(supplier $supplier)
    {


        $supplier->delete();

        return redirect()->route('admin.suppliers')->with('success', 'supplier deleted successfully.');
    }
    public function edit(supplier $supplier)
    {
        return view('admin.suppliers.suppliersedit', compact('supplier'));
    }
    public function update(Request $request, supplier $supplier)
    {
        $request->validate([
            'Supplier_Name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'Contact_Phone' => 'nullable|string|max:30',
            'Contact_Person' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'is_active' => 'required|boolean',
        ]);

        $supplier->update($request->all());

        return redirect()->route('admin.suppliers')->with('success', 'Supplier updated successfully!');
    }
}
