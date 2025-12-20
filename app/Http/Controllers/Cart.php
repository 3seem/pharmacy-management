<?php

namespace App\Http\Controllers;

use App\Models\Cart as ModelsCart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Cart extends Controller
{
    //
    
    /* ===============================
       SHOW CART
    =============================== */
    public function index()
    {
        $cart = ModelsCart::with('medicine')
            ->where('user_id', Auth::id())
            ->get();

        return view('cart', compact('cart'));
    }

    /* ===============================
       ADD TO CART
    =============================== */
    public function add(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:medicines,medicine_id',
        ]);

        $cartItem = ModelsCart::where('user_id', Auth::id())
            ->where('medicine_id', $request->id)
            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity');
        } else {
            ModelsCart::create([
                'user_id'     => Auth::id(),
                'medicine_id' => $request->id,
                'quantity'    => 1,
            ]);
        }

        return redirect()->back()->with('success', 'Item added to cart');
    }

    /* ===============================
       UPDATE QUANTITY
    =============================== */
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:carts,id',
            'quantity' => 'required|integer|min:1',
        ]);

        ModelsCart::where('id', $request->id)
            ->where('user_id', Auth::id())
            ->update(['quantity' => $request->quantity]);

        return redirect()->back();
    }

    /* ===============================
       REMOVE ITEM
    =============================== */
    public function remove(Request $request)
    {
        ModelsCart::where('id', $request->id)
            ->where('user_id', Auth::id())
            ->delete();

        return redirect()->back();
    }
}
