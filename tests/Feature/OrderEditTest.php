<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;

class OrderEditTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();

        // Grant all abilities to bypass policies
        Gate::before(fn($user, $ability) => true);
    }

    protected function loginAdmin()
    {
        // Fetch an admin user or create one
        $user = User::where('role', 'admin')->first();

        if (! $user) {
            $user = User::factory()->create([
                'role' => 'admin',
                'email_verified_at' => now(), // mark as verified
            ]);
        } else {
            $user->email_verified_at = now(); // ensure verified
            $user->save();
        }

        $this->actingAs($user);
    }

    private function createCustomer()
    {
        DB::table('customers')->insert([
            'id' => 1,
            'total_purchases' => 0,
        ]);

        return 1;
    }

    private function createMedicine($stock = 10)
    {
        $medicineId = DB::table('medicines')->insertGetId([
            'Name'        => 'Panadol',
            'Price'       => 10,
            'Stock'       => $stock,
            'Category'    => 'Painkiller',
            'dosage_form' => 'Tablet',
        ]);

        return (object)[
            'medicine_id' => $medicineId,
            'Price' => 10
        ];
    }

    private function createOrder()
    {
        $customerId = $this->createCustomer();
        $medicine = $this->createMedicine();

        $orderId = DB::table('orders')->insertGetId([
            'customer_id'   => $customerId,
            'Total_amount'  => $medicine->Price * 2,
            'delivery_type' => 'pickup',
        ]);

        DB::table('order_items')->insert([
            'order_id'    => $orderId,
            'medicine_id' => $medicine->medicine_id,
            'Quantity'    => 2,
            'subtotal'    => $medicine->Price * 2,
        ]);

        return DB::table('orders')->where('Order_ID', $orderId)->first();
    }

    public function test_edit_order_page_can_be_rendered(): void
    {
        $this->loginAdmin();
        $order = $this->createOrder();

        $response = $this->get(route('orders.edit', $order->Order_ID));

        $response->assertStatus(200);
        $response->assertSeeText("Edit Order #{$order->Order_ID}");
    }

    public function test_order_items_can_be_updated(): void
    {
        $this->loginAdmin();
        $order = $this->createOrder();
        $medicine2 = $this->createMedicine();

        $response = $this->post(route('orders.updateItems', $order->Order_ID), [
            'items' => [
                [
                    'medicine_id' => $medicine2->medicine_id,
                    'Quantity'    => 3,
                ],
            ],
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('admin.orders'));

        $this->assertDatabaseHas('order_items', [
            'order_id'    => $order->Order_ID,
            'medicine_id' => $medicine2->medicine_id,
            'Quantity'    => 3,
        ]);
    }

    public function test_cannot_update_order_with_empty_items(): void
    {
        $this->loginAdmin();
        $order = $this->createOrder();

        $response = $this->post(route('orders.updateItems', $order->Order_ID), [
            'items' => [],
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('order_items', [
            'order_id' => $order->Order_ID,
        ]);
    }
}
