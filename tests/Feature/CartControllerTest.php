<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

class CartControllerTest extends TestCase
{
    protected $user;
    protected $medicine;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = \DB::table('users')->where('email', 'testuser@example.com')->first();
        if (!$this->user) {
            $userId = \DB::table('users')->insertGetId([
                'name' => 'Test User',
                'email' => 'testuser@example.com',
                'password' => bcrypt('password'),
            ]);
            $this->user = \DB::table('users')->where('id', $userId)->first();
        }

        $this->medicine = \DB::table('medicines')->where('name', 'Test Medicine')->first();
        if (!$this->medicine) {
            $medicineId = \DB::table('medicines')->insertGetId([
                'name' => 'Test Medicine',
                'price' => 10,
                'description' => 'Test Description',
            ]);
            $this->medicine = \DB::table('medicines')->where('medicine_id', $medicineId)->first();
        }
    }

    public function test_user_can_view_cart()
    {
        $response = $this->actingAs(\App\Models\User::find($this->user->id))
                         ->get(route('cart.index'));

        $response->assertStatus(200);
        $response->assertViewHas('cart');
    }

    public function test_user_can_add_item_to_cart()
    {
        $response = $this->actingAs(\App\Models\User::find($this->user->id))
                         ->post(route('cart.add'), [
                             'id' => $this->medicine->medicine_id,
                         ]);

        $response->assertStatus(302);
        $response->assertSessionHas('success', 'Item added to cart');
    }

    public function test_user_can_update_cart_quantity()
    {
        $cartId = \DB::table('carts')->insertGetId([
            'user_id' => $this->user->id,
            'medicine_id' => $this->medicine->medicine_id,
            'quantity' => 1,
        ]);

        $response = $this->actingAs(\App\Models\User::find($this->user->id))
                         ->post(route('cart.update'), [   // <-- استخدم POST
                             'id' => $cartId,
                             'quantity' => 5,
                         ]);

        $response->assertStatus(302);
    }

    public function test_user_can_remove_cart_item()
    {
        $cartId = \DB::table('carts')->insertGetId([
            'user_id' => $this->user->id,
            'medicine_id' => $this->medicine->medicine_id,
            'quantity' => 1,
        ]);

        $response = $this->actingAs(\App\Models\User::find($this->user->id))
                         ->post(route('cart.remove'), ['id' => $cartId]); 

        $response->assertStatus(302);
    }
}
