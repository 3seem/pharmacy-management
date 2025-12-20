<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        $medicine = DB::table('medicine')->get();
        $categories = DB::table('medicine')->select('Category')->distinct()->get();

        return view('pharmacare', compact('medicine', 'categories'));
    }

    public function search(Request $request)
    {
        $search = $request->q;

        $medicine = DB::table('medicine')
                    ->where('Name', 'LIKE', "%{$search}%")
                    ->get();

        return view('search_results', compact('medicine', 'search'));
    }
}
