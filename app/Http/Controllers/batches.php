<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Batch;
use App\Models\Medicine;

use Illuminate\Support\Facades\DB;
class batches extends Controller
{
    //
    public function index(Request $request)
    {
        $query = Batch::with('medicine');

        if ($request->search) {
            $query->where('batch_number', 'like', '%' . $request->search . '%');
        }

        if ($request->expiry == 'expired') {
            $query->whereDate('exp_date', '<', now());
        }

        if ($request->expiry == 'valid') {
            $query->whereDate('exp_date', '>=', now());
        }

        $batches = $query->orderBy('exp_date')->get();

        return view('admin.batches.batches', [
            'batches' => $batches,
            'total_batches' => Batch::count(),
            'expired_batches' => Batch::whereDate('exp_date', '<', now())->count(),
            'total_stock' => Batch::sum('current_stock'),
        ]);
    }
    public function create()
    {
        return view('admin.batches.create', [
            'medicines' => Medicine::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'batch_number'   => 'required|unique:batches,batch_number',
            'mfg_date'       => 'required|date',
            'exp_date'       => 'required|date|after:mfg_date',
            'quantity'       => 'required|integer|min:1',
            'purchase_price' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request) {

            $batch = Batch::create([
                'batch_number'   => $request->batch_number,
                'medicine_id'    => $request->medicine_id,
                'mfg_date'       => $request->mfg_date,
                'exp_date'       => $request->exp_date,
                'quantity'       => $request->quantity,
                'current_stock'  => $request->quantity,
                'purchase_price' => $request->purchase_price,
                'cost_per_unit'  => $request->purchase_price,
            ]);

            // ✅ CORRECT COLUMN NAME
            if ($batch->medicine_id) {
                Medicine::where('medicine_id', $batch->medicine_id)
                    ->increment('Stock', $batch->quantity);
            }
        });

        return redirect()
            ->route('admin.batches')
            ->with('success', 'Batch created & medicine stock updated');
    }

    public function destroy($batch_number)
    {
        DB::transaction(function () use ($batch_number) {

            $batch = Batch::findOrFail($batch_number);

            if ($batch->medicine_id) {
                Medicine::where('medicine_id', $batch->medicine_id)
                    ->decrement('Stock', $batch->current_stock);
            }

            $batch->delete(); // triggers audit logs
        });

        return redirect()
            ->route('admin.batches')
            ->with('success', 'Batch deleted & medicine stock updated');
    }
}
