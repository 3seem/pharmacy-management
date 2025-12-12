<?php

namespace App\Http\Controllers;

use App\Models\medicine;
use App\Models\supplier;
use Illuminate\Http\Request;

class medicines extends Controller
{
    //
    public function medcine()
    {
        $medicines =medicine::get();
        return view('admin.medicine.medicine', compact('medicines'));
    }
    public function destroy(medicine $medicine)
    {
        if ($medicine->poster && file_exists(public_path($medicine->image_url))) {
            unlink(public_path($medicine->image_url));
        }

        $medicine->delete();

        return redirect()->route('admin.medicine')->with('success', 'medicine deleted successfully.');
    }
    public function edit(medicine $medicine)
    {
        return view('admin.medicine.medicineedit', compact('medicine'));
    }
    public function update(Request $request, medicine $medicine)
    {
        $request->validate([
            'Name' => 'required|string|max:200',
            'Category' => 'nullable|string|max:50',
            'Price' => 'required|numeric|min:0',
            'Stock' => 'required|integer|min:0',
            'Description' => 'nullable|string',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'low_stock_threshold' => 'required|integer|min:0',
            'generic_name' => 'nullable|string|max:200',
            'manufacturer' => 'nullable|string|max:100',
            'dosage_form' => 'required|in:Tablet,Capsule,Syrup,Injection',
            'strength' => 'nullable|string|max:50',
            'is_active' => 'required|boolean',
        ]);

        $data = $request->except('image_url');

        // Handle Image Upload
        if ($request->hasFile('image_url')) {

            // delete old image if exists
            if ($medicine->image_url && file_exists(public_path($medicine->image_url))) {
                unlink(public_path($medicine->image_url));
            }

            $image = $request->file('image_url');
            $filename = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/image_url'), $filename);

            $data['image_url'] = 'uploads/image_url/' . $filename;
        }

        $medicine->update($data);

        return redirect()->route('admin.medicine')->with('success', 'Medicine updated successfully.');
    }
    public function create()
    {
        return view('admin.medicine.medicineadd');
    }

    public function store(Request $request)
    {
        
        $request->validate([
            'Name' => 'required|string|max:200',
            'Category' => 'nullable|string|max:50',
            'Price' => 'required|numeric|min:0',
            'Stock' => 'required|integer|min:0',
            'Description' => 'nullable|string',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'low_stock_threshold' => 'required|integer|min:0',
            'generic_name' => 'nullable|string|max:200',
            'manufacturer' => 'nullable|string|max:100',
            'dosage_form' => 'required|in:Tablet,Capsule,Syrup,Injection',
            'strength' => 'nullable|string|max:50',
            'is_active' => 'required|boolean',
        ]);
        

        $data = $request->all();
        
        if ($request->hasFile('image_url')) {
            $image_url = $request->file('image_url');
            $filename = time() . '_' . $image_url->getClientOriginalName();
            $image_url->move(public_path('uploads/image_url'), $filename);
            $data['image_url'] = 'uploads/image_url/' . $filename;
        }
        
        medicine::create($data);
        
        return redirect()->route('admin.medicine')->with('success', 'medicine created successfully.');
    }
}
