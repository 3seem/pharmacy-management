<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class OrdersControllerTest extends TestCase
{
    protected $user;
    protected $customer;
    protected $medicine;

    protected function setUp(): void
    {
        parent::setUp();

        DB::table('carts')->delete();
        DB::table('orders')->delete();
        DB::table('order_items')->delete();
        DB::table('customers')->delete();
        DB::table('medicines')->delete();
        DB::table('users')->where('email', 'testuser@example.com')->delete();

        $user = DB::table('users')->where('email', 'testuser@example.com')->first();
        if (!$user) {
            $userId = DB::table('users')->insertGetId([
                'name' => 'Test User',
                'email' => 'testuser@example.com',
                'password' => bcrypt('password'),
            ]);
            $user = DB::table('users')->where('id', $userId)->first();
        }
        $this->user = User::find($user->id); 

        DB::table('customers')->updateOrInsert(
            ['id' => $this->user->id],
            ['total_purchases' => 0]
        );
        $this->customer = DB::table('customers')->where('id', $this->user->id)->first();

        $medicine = DB::table('medicines')->where('name', 'Test Medicine')->first();
        if (!$medicine) {
            $medicineId = DB::table('medicines')->insertGetId([
                'name' => 'Test Medicine',
                'Price' => 100,
                'Stock' => 10,
                'description' => 'Test Description',
                'Category' => 'Test Category',
            ]);
            $medicine = DB::table('medicines')->where('medicine_id', $medicineId)->first();
        }
        $this->medicine = $medicine;
    }

    public function test_user_can_checkout_cart_and_create_order()
    {
        $cartId = DB::table('carts')->insertGetId([
            'user_id' => $this->user->id,
            'medicine_id' => $this->medicine->medicine_id,
            'quantity' => 2,
        ]);

        $response = $this->actingAs($this->user)
                         ->post(route('checkout.cart'));

        $response->assertRedirect(route('cart.index'));
        $response->assertSessionHas('success');

        // تأكد أن الكارت اتفاضى
        $this->assertDatabaseMissing('carts', [
            'id' => $cartId,
        ]);

        // تأكد أن الأوردر اتعمل
        $this->assertDatabaseHas('orders', [
            'Customer_ID' => $this->customer->id,
            'Status' => 'Pending',
        ]);

        // تحقق إن stock قل
        $newStock = DB::table('medicines')->where('medicine_id', $this->medicine->medicine_id)->value('Stock');
        $this->assertEquals(8, $newStock);
    }

    public function test_user_cannot_checkout_empty_cart()
    {
        // نتأكد الكارت فاضي
        DB::table('carts')->where('user_id', $this->user->id)->delete();

        $response = $this->actingAs($this->user)
                         ->post(route('checkout.cart'));

        // تأكد من redirect ووجود رسالة خطأ
        $response->assertRedirect(route('cart.index'));
        $response->assertSessionHas('error');
    }
}
