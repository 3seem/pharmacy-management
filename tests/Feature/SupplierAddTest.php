<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Attributes\Test;

class SupplierAddTest extends TestCase
{
    use DatabaseTransactions, WithoutMiddleware;

    private function loginAdmin()
    {
        $admin = User::create([
            'name'              => 'Admin',
            'email'             => 'admin@test.com',
            'password'          => Hash::make('password'),
            'role'              => 'admin',
            'email_verified_at' => now(),
        ]);

        $this->actingAs($admin);
    }

    #[Test]
    public function add_supplier_page_can_be_rendered()
    {
        $this->loginAdmin();

        // FIX: provide empty error bag so Blade doesn't crash
        $this->withViewErrors([]);

        $response = $this->get(route('admin.suppliers.create'));

        $response->assertStatus(200);
        $response->assertSee('Add New Supplier');
        $response->assertSee('Supplier Name');
        $response->assertSee('Add Supplier');
    }

    #[Test]
    public function supplier_can_be_added_successfully()
    {
        $this->loginAdmin();

        $response = $this->post(route('admin.suppliers.store'), [
            'Supplier_Name'  => 'Test Supplier',
            'email'          => 'supplier@test.com',
            'Contact_Phone'  => '01000000000',
            'Contact_Person' => 'Ahmed Ali',
            'address'        => 'Cairo',
            'city'           => 'Cairo',
            'is_active'      => 1,
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('admin.suppliers'));

        $this->assertDatabaseHas('suppliers', [
            'Supplier_Name' => 'Test Supplier',
            'email'         => 'supplier@test.com',
            'city'          => 'Cairo',
            'is_active'     => 1,
        ]);
    }

    #[Test]
    public function supplier_name_is_required()
    {
        $this->loginAdmin();

        $response = $this->post(route('admin.suppliers.store'), [
            'email'          => 'supplier@test.com',
            'Contact_Phone'  => '01000000000',
            'Contact_Person' => 'Ahmed',
            'address'        => 'Cairo',
            'city'           => 'Cairo',
            'is_active'      => 1,
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('Supplier_Name');
    }

    #[Test]
    public function is_active_field_is_required()
    {
        $this->loginAdmin();

        $response = $this->post(route('admin.suppliers.store'), [
            'Supplier_Name'  => 'No Status Supplier',
            'email'          => 'supplier@test.com',
            'Contact_Phone'  => '01000000000',
            'Contact_Person' => 'Ahmed',
            'address'        => 'Cairo',
            'city'           => 'Cairo',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('is_active');
    }

    #[Test]
    public function invalid_email_is_rejected()
    {
        $this->loginAdmin();

        $response = $this->post(route('admin.suppliers.store'), [
            'Supplier_Name'  => 'Invalid Email Supplier',
            'email'          => 'not-an-email',
            'Contact_Phone'  => '01000000000',
            'Contact_Person' => 'Ahmed',
            'address'        => 'Cairo',
            'city'           => 'Cairo',
            'is_active'      => 1,
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('email');
    }


    

    

    

    #[Test]
    public function supplier_is_not_inserted_when_validation_fails()
    {
        $this->loginAdmin();

        $this->post(route('admin.suppliers.store'), [
            'email'         => 'fail@test.com',
            'Contact_Phone' => '01044444444',
            'is_active'     => 1,
        ]);

        $this->assertDatabaseMissing('suppliers', [
            'email' => 'fail@test.com',
        ]);
    }

    #[Test]
    public function old_input_is_flashed_on_validation_error()
    {
        $this->loginAdmin();

        $response = $this->post(route('admin.suppliers.store'), [
            'Supplier_Name'  => '',
            'email'          => 'oldinput@test.com',
            'Contact_Phone'  => '01055555555',
            'Contact_Person' => 'Ahmed',
            'address'        => 'Cairo',
            'city'           => 'Cairo',
            'is_active'      => 1,
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasInput('email', 'oldinput@test.com');
    }


    #[Test]
    public function supplier_can_be_added_without_email()
    {
        $this->loginAdmin();

        $response = $this->post(route('admin.suppliers.store'), [
            'Supplier_Name'  => 'No Email Supplier',
            'Contact_Phone'  => '01077777777',
            'Contact_Person' => 'Ahmed',
            'address'        => 'Cairo',
            'city'           => 'Cairo',
            'is_active'      => 1,
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('suppliers', [
            'Supplier_Name' => 'No Email Supplier',
            'email'         => null,
        ]);
    }

    #[Test]
    public function supplier_can_be_added_without_phone()
    {
        $this->loginAdmin();

        $response = $this->post(route('admin.suppliers.store'), [
            'Supplier_Name'  => 'No Phone Supplier',
            'email'          => 'nophone@test.com',
            'Contact_Person' => 'Ahmed',
            'address'        => 'Cairo',
            'city'           => 'Cairo',
            'is_active'      => 1,
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('suppliers', [
            'email' => 'nophone@test.com',
        ]);
    }

    #[Test]
    public function supplier_can_be_added_without_city()
    {
        $this->loginAdmin();

        $response = $this->post(route('admin.suppliers.store'), [
            'Supplier_Name'  => 'No City Supplier',
            'email'          => 'nocity@test.com',
            'Contact_Phone'  => '01088888888',
            'Contact_Person' => 'Ahmed',
            'address'        => 'Cairo',
            'is_active'      => 1,
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('suppliers', [
            'email' => 'nocity@test.com',
            'city'  => null,
        ]);
    }

    #[Test]
    public function duplicate_supplier_emails_are_allowed()
    {
        $this->loginAdmin();

        $this->post(route('admin.suppliers.store'), [
            'Supplier_Name'  => 'Supplier One',
            'email'          => 'duplicate@test.com',
            'is_active'      => 1,
        ]);

        $this->post(route('admin.suppliers.store'), [
            'Supplier_Name'  => 'Supplier Two',
            'email'          => 'duplicate@test.com',
            'is_active'      => 1,
        ]);

        $this->assertDatabaseHas('suppliers', [
            'Supplier_Name' => 'Supplier One',
            'email'         => 'duplicate@test.com',
        ]);

        $this->assertDatabaseHas('suppliers', [
            'Supplier_Name' => 'Supplier Two',
            'email'         => 'duplicate@test.com',
        ]);

        $this->assertEquals(
            2,
            DB::table('suppliers')
                ->where('email', 'duplicate@test.com')
                ->count()
        );
    }
}
