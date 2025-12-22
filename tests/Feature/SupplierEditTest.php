<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Supplier;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\Test;

class SupplierEditTest extends TestCase
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
    public function edit_supplier_page_can_be_rendered()
    {
        $this->loginAdmin();

        $supplier = Supplier::create([
            'Supplier_Name' => 'Old Supplier',
            'email'         => 'old@test.com',
            'Contact_Phone' => '01000000000',
            'Contact_Person' => 'Ahmed',
            'address'       => 'Cairo',
            'city'          => 'Cairo',
            'is_active'     => 1,
        ]);

        $response = $this->get(route('admin.suppliers.edit', ['supplier' => $supplier->Supplier_ID]));

        $response->assertStatus(200);
        $response->assertSee('Edit Supplier');
        $response->assertSee($supplier->Supplier_Name);
    }

    #[Test]
    public function supplier_can_be_updated_successfully()
    {
        $this->loginAdmin();

        $supplier = Supplier::create([
            'Supplier_Name' => 'Old Supplier',
            'email'         => 'old@test.com',
            'Contact_Phone' => '01000000000',
            'Contact_Person' => 'Ahmed',
            'address'       => 'Cairo',
            'city'          => 'Cairo',
            'is_active'     => 1,
        ]);

        $response = $this->put(route('admin.suppliers.update', ['supplier' => $supplier->Supplier_ID]), [
            'Supplier_Name'   => 'Updated Supplier',
            'email'           => 'updated@test.com',
            'Contact_Phone'   => $supplier->Contact_Phone,
            'Contact_Person'  => $supplier->Contact_Person,
            'address'         => $supplier->address,
            'city'            => 'Giza',
            'is_active'       => 0,
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('admin.suppliers'));

        $this->assertDatabaseHas('suppliers', [
            'Supplier_ID'    => $supplier->Supplier_ID,
            'Supplier_Name'  => 'Updated Supplier',
            'email'          => 'updated@test.com',
            'city'           => 'Giza',
            'is_active'      => 0,
        ]);
    }

    #[Test]
    public function supplier_name_is_required_on_update()
    {
        $this->loginAdmin();

        $supplier = Supplier::create([
            'Supplier_Name' => 'Old Supplier',
            'email'         => 'old@test.com',
            'Contact_Phone' => '01000000000',
            'Contact_Person' => 'Ahmed',
            'address'       => 'Cairo',
            'city'          => 'Cairo',
            'is_active'     => 1,
        ]);

        $response = $this->from(route('admin.suppliers.edit', ['supplier' => $supplier->Supplier_ID]))
            ->put(route('admin.suppliers.update', ['supplier' => $supplier->Supplier_ID]), [
                'Supplier_Name' => '',
                'email'         => 'updated@test.com',
                'city'          => 'Giza',
                'is_active'     => 1,
            ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('admin.suppliers.edit', ['supplier' => $supplier->Supplier_ID]));
        $response->assertSessionHasErrors('Supplier_Name');
    }

    #[Test]
    public function supplier_is_not_updated_when_validation_fails()
    {
        $this->loginAdmin();

        $supplier = Supplier::create([
            'Supplier_Name' => 'Old Supplier',
            'email'         => 'old@test.com',
            'Contact_Phone' => '01000000000',
            'Contact_Person' => 'Ahmed',
            'address'       => 'Cairo',
            'city'          => 'Cairo',
            'is_active'     => 1,
        ]);

        $this->put(route('admin.suppliers.update', ['supplier' => $supplier->Supplier_ID]), [
            'Supplier_Name' => '',
            'is_active'     => '',
        ]);

        $this->assertDatabaseHas('suppliers', [
            'Supplier_ID'   => $supplier->Supplier_ID,
            'Supplier_Name' => 'Old Supplier',
        ]);
    }

    #[Test]
    public function old_input_is_flashed_on_update_validation_error()
    {
        $this->loginAdmin();

        $supplier = Supplier::create([
            'Supplier_Name' => 'Old Supplier',
            'email'         => 'old@test.com',
            'Contact_Phone' => '01000000000',
            'Contact_Person' => 'Ahmed',
            'address'       => 'Cairo',
            'city'          => 'Cairo',
            'is_active'     => 1,
        ]);

        $response = $this->from(route('admin.suppliers.edit', ['supplier' => $supplier->Supplier_ID]))
            ->put(route('admin.suppliers.update', ['supplier' => $supplier->Supplier_ID]), [
                'Supplier_Name' => '',
                'email'         => 'invalid-email',
                'is_active'     => 1,
            ]);

        $response->assertRedirect(route('admin.suppliers.edit', ['supplier' => $supplier->Supplier_ID]));
        $response->assertSessionHasErrors(['Supplier_Name', 'email']);
        $this->assertEquals(session()->getOldInput('email'), 'invalid-email');
    }

    #[Test]
    public function supplier_can_be_updated_without_optional_fields()
    {
        $this->loginAdmin();

        $supplier = Supplier::create([
            'Supplier_Name' => 'Old Supplier',
            'email'         => 'old@test.com',
            'Contact_Phone' => '01000000000',
            'Contact_Person' => 'Ahmed',
            'address'       => 'Cairo',
            'city'          => 'Cairo',
            'is_active'     => 1,
        ]);

        $response = $this->put(route('admin.suppliers.update', ['supplier' => $supplier->Supplier_ID]), [
            'Supplier_Name'   => 'Minimal Update',
            'email'           => $supplier->email,
            'Contact_Phone'   => $supplier->Contact_Phone,
            'Contact_Person'  => $supplier->Contact_Person,
            'address'         => $supplier->address,
            'city'            => 'Giza',
            'is_active'       => 0,
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('admin.suppliers'));

        $this->assertDatabaseHas('suppliers', [
            'Supplier_ID'   => $supplier->Supplier_ID,
            'Supplier_Name' => 'Minimal Update',
        ]);
    }
}
