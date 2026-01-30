<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\order;
use App\Models\Medicine;
use App\Models\Customer;
use App\Models\order_item as OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class orders extends Controller
{

    public function orders(Request $request)
    {
        $total_orders = Order::count();
        $pending = Order::where('Status', '=', 'Pending')->count();
        $Completed = Order::where('Status', '=', 'Completed')->count();
        $Total_amount = Order::sum('Total_amount');

        $orders = Order::with(['customer', 'employee'])
            ->when($request->search, function ($query) use ($request) {
                $query->whereHas('customer', function ($q) use ($request) {
                    $q->where('name', 'LIKE', '%' . $request->search . '%');
                });
            })
            ->when($request->status, function ($query) use ($request) {
                $query->where('Status', $request->status);
            })
            ->orderBy('Order_Date', 'desc')
            ->get();

        return view('admin.orders.orders', compact('orders', 'total_orders', 'pending', 'Completed', 'Total_amount'));
    }

    public function markCompleted(Order $order)
    {
        // Only update if order is pending
        if ($order->Status === 'Pending') {
            $order->update([
                'Status' => 'Completed',
                'Employee_ID' => Auth::id(),
                'updated_at' => now(),
            ]);

            return redirect()->back()->with('success', 'Order marked as Completed.');
        }

        return redirect()->back()->with('error', 'Order is already completed.');
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);

        // This will automatically delete related order_items because of ON DELETE CASCADE
        $order->delete();

        return redirect()->back()->with('success', 'Order and its items deleted successfully.');
    }

    public function edit(Order $order)
    {
        // Load items
        $order->load('items');

        return view('admin.orders.edit', compact('order'));
    }

    public function updateItems(Request $request, Order $order)
    {
        $totalAmount = 0;

        foreach ($request->items as $itemData) {
            // Get the medicine to fetch the current price
            $medicine = Medicine::find($itemData['medicine_id']);

            if ($medicine) {
                $quantity = $itemData['Quantity'];
                $unit_price = $medicine->Price;
                $subtotal = $quantity * $unit_price;

                OrderItem::updateComposite(
                    $order->Order_ID,
                    $itemData['medicine_id'],
                    [
                        'Quantity' => $quantity,
                        'unit_price' => $unit_price,
                        'subtotal' => $subtotal,
                    ]
                );

                $totalAmount += $subtotal;
            }
        }

        $order->update([
            'Total_amount' => $totalAmount,
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Order items updated successfully.');
    }

    public function deleteItem(Order $order, $medicine)
    {
        OrderItem::where('Order_ID', $order->Order_ID)
            ->where('medicine_id', $medicine)
            ->delete();

        // Recalculate total
        $totalAmount = OrderItem::where('Order_ID', $order->Order_ID)
            ->sum('subtotal');

        $order->update([
            'Total_amount' => $totalAmount,
        ]);

        return back()->with('success', 'Item deleted successfully.');
    }

    public function create()
    {
        $medicines = Medicine::query()
            ->when(request('search'), function ($q) {
                $q->where('Name', 'like', '%' . request('search') . '%');
            })
            ->when(request('category'), function ($q) {
                $q->where('Category', request('category'));
            })
            ->where('Stock', '>', 0)
            ->get();

        // Get unique categories from medicines table
        $categories = Medicine::distinct()
            ->pluck('Category')
            ->filter()
            ->sort()
            ->values();

        $customers = Customer::with('user')
            ->get()
            ->sortBy(function ($c) {
                return $c->user->name;
            });

        return view('admin.orders.createorder', compact('medicines', 'categories', 'customers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'items' => 'required|array|min:1',
        ]);

        // 1) CHECK STOCK BEFORE TRANSACTION
        foreach ($request->items as $item) {
            $medicine = Medicine::findOrFail($item['medicine_id']);
            if ($medicine->Stock < $item['Quantity']) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', $medicine->Name . ' has insufficient stock.');
            }
        }

        DB::beginTransaction();

        try {
            // 2) CREATE ORDER
            $order = Order::create([
                'Customer_ID' => $request->customer_id,
                'Employee_ID' => Auth::id(),
                'Status' => 'Completed',
                'delivery_type' => $request->delivery_type,
                'Total_amount' => 0,
                'Order_Date' => now(),
            ]);

            $totalAmount = 0;

            // 3) LOOP THROUGH ITEMS
            foreach ($request->items as $item) {
                $medicine = Medicine::findOrFail($item['medicine_id']);
                $subtotal = $item['Quantity'] * $medicine->Price;

                // SAVE ORDER ITEM
                OrderItem::create([
                    'Order_ID' => $order->Order_ID,
                    'medicine_id' => $medicine->medicine_id,
                    'Quantity' => $item['Quantity'],
                    'unit_price' => $medicine->Price,
                    'subtotal' => $subtotal,
                ]);

                // REDUCE MEDICINE STOCK
                $medicine->decrement('Stock', $item['Quantity']);

                $totalAmount += $subtotal;
            }

            // UPDATE ORDER TOTAL
            $order->update(['Total_amount' => $totalAmount]);

            // UPDATE CUSTOMER TOTAL PURCHASE
            Customer::where('id', $request->customer_id)
                ->increment('total_purchases', $totalAmount);

            DB::commit();

            // SUCCESS REDIRECT
            return redirect()->route('admin.orders')
                ->with('success', 'Order created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->withInput()
                ->with('error', 'Error creating order: ' . $e->getMessage());
        }
    }

    public function checkoutFromCart()
    {
        $cart = Cart::with('medicine')
            ->where('user_id', Auth::id())
            ->get();

        if ($cart->count() == 0) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty');
        }

        DB::beginTransaction();

        try {
            // Get customer linked to logged-in user
            $customer = Customer::where('user_id', Auth::id())->firstOrFail();

            // 1️⃣ Create order (PENDING)
            $order = Order::create([
                'Customer_ID' => $customer->id,
                'Employee_ID' => null,
                'Status' => 'Pending',
                'delivery_type' => 'delivery',
                'Total_amount' => 0,
                'Order_Date' => now(),
            ]);

            $totalAmount = 0;

            // 2️⃣ Move cart items → order_items
            foreach ($cart as $item) {
                $medicine = $item->medicine;

                // Stock check
                if ($medicine->Stock < $item->quantity) {
                    throw new \Exception($medicine->Name . ' out of stock');
                }

                $subtotal = $item->quantity * $medicine->Price;

                OrderItem::create([
                    'Order_ID' => $order->Order_ID,
                    'medicine_id' => $medicine->medicine_id,
                    'Quantity' => $item->quantity,
                    'unit_price' => $medicine->Price,
                    'subtotal' => $subtotal,
                ]);

                // Reduce stock
                $medicine->decrement('Stock', $item->quantity);

                $totalAmount += $subtotal;
            }

            // 3️⃣ Update order total
            $order->update(['Total_amount' => $totalAmount]);

            // 4️⃣ Update customer total purchases
            Customer::where('id', $customer->id)
                ->increment('total_purchases', $totalAmount);

            // 5️⃣ Clear cart
            Cart::where('user_id', Auth::id())->delete();

            DB::commit();

            return redirect()->route('cart.index')
                ->with('success', 'Order placed successfully and is pending.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('cart.index')
                ->with('error', $e->getMessage());
        }
    }

}