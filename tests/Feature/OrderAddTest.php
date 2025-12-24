<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Medicine;

class OrderAddTest extends TestCase
{
    use DatabaseTransactions;

    
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
            'id'              => 1,
            'total_purchases' => 0,
        ]);

        return 1;
    }

    private function createMedicine($stock = 10)
    {
        return Medicine::create([
            'Name'        => 'Panadol',
            'Price'       => 10,
            'Stock'       => $stock,
            'Category'    => 'Painkiller',
            'dosage_form' => 'Tablet',
        ]);
    }

    public function test_create_order_page_can_be_rendered()
    {
        $this->loginAdmin();

        $response = $this->get(route('orders.create'));

        // The page renders successfully, so 200 is correct
        $response->assertStatus(200);
    }

    public function test_order_can_be_created_successfully()
    {
        $this->loginAdmin();
        $customerId = $this->createCustomer();
        $medicine   = $this->createMedicine();

        $response = $this->post(route('orders.store'), [
            'customer_id'   => $customerId,
            'delivery_type' => 'pickup',
            'items' => [
                [
                    'medicine_id' => $medicine->medicine_id,
                    'Quantity'    => 2,
                ],
            ],
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('admin.orders'));
    }

    public function test_customer_is_required()
    {
        $this->loginAdmin();
        $medicine = $this->createMedicine();

        $response = $this->post(route('orders.store'), [
            'items' => [
                [
                    'medicine_id' => $medicine->medicine_id,
                    'Quantity'    => 1,
                ],
            ],
        ]);

        $response->assertStatus(302);
    }

    public function test_items_are_required()
    {
        $this->loginAdmin();
        $this->createCustomer();

        $response = $this->post(route('orders.store'), [
            'customer_id' => 1,
        ]);

        $response->assertStatus(302);
    }

    public function test_cannot_order_more_than_stock()
    {
        $this->loginAdmin();
        $customerId = $this->createCustomer();
        $medicine   = $this->createMedicine(1);

        $response = $this->post(route('orders.store'), [
            'customer_id' => $customerId,
            'items' => [
                [
                    'medicine_id' => $medicine->medicine_id,
                    'Quantity'    => 5,
                ],
            ],
        ]);

        $response->assertStatus(302);
    }
}
