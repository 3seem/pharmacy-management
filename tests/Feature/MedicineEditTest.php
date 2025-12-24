<?php

namespace Tests\Feature;

use App\Models\medicine;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class MedicineEditTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Helper to log in as an admin user
     */
    protected function loginAdmin()
    {
        $user = User::where('role', 'admin')->first();

        if (!$user) {
            $user = User::factory()->create([
                'role' => 'admin',
                'email_verified_at' => now(),
            ]);
        } else {
            $user->email_verified_at = now();
            $user->save();
        }

        $this->actingAs($user);
    }

    /**
     * Helper to create a medicine manually
     */
    protected function createMedicine()
    {
        return medicine::create([
            'Name' => 'Test Medicine',
            'Category' => 'Painkiller',
            'Price' => 50,
            'Stock' => 100,
            'Description' => 'Test description',
            'low_stock_threshold' => 10,
            'dosage_form' => 'Tablet',
            'strength' => '500mg',
            'is_active' => 1,
        ]);
    }

    /** @test */
    public function test_edit_medicine_page_can_be_rendered()
    {
        $this->loginAdmin();
        $medicine = $this->createMedicine();

        $response = $this->get(route('admin.medicine.edit', $medicine->medicine_id));
        $response->assertStatus(200);
        $response->assertSee('Edit Medicine');
        $response->assertSee($medicine->Name);
    }

    /** @test */
    public function test_medicine_can_be_updated_without_image()
    {
        $this->loginAdmin();
        $medicine = $this->createMedicine();

        $response = $this->put(route('admin.medicine.update', $medicine->medicine_id), [
            'Name' => 'Updated Medicine',
            'Category' => 'Antibiotic',
            'Price' => 75,
            'Stock' => 120,
            'Description' => 'Updated description',
            'low_stock_threshold' => 5,
            'dosage_form' => 'Tablet',
            'strength' => '250mg',
            'is_active' => 1,
        ]);

        $response->assertRedirect(route('admin.medicine'));
        $this->assertDatabaseHas('medicines', ['Name' => 'Updated Medicine']);
    }

    /** @test */
    public function test_name_is_required_on_edit()
    {
        $this->loginAdmin();
        $medicine = $this->createMedicine();

        $response = $this->from(route('admin.medicine.edit', $medicine->medicine_id))
            ->put(route('admin.medicine.update', $medicine->medicine_id), [
                'Name' => '',
                'Category' => 'Antibiotic',
                'Price' => 75,
                'Stock' => 120,
                'low_stock_threshold' => 5,
                'dosage_form' => 'Tablet',
                'strength' => '250mg',
                'is_active' => 1,
            ]);

        $response->assertRedirect(route('admin.medicine.edit', $medicine->medicine_id));
        $response->assertSessionHasErrors('Name');
    }

    /** @test */
    public function test_price_must_be_numeric_on_edit()
    {
        $this->loginAdmin();
        $medicine = $this->createMedicine();

        $response = $this->from(route('admin.medicine.edit', $medicine->medicine_id))
            ->put(route('admin.medicine.update', $medicine->medicine_id), [
                'Name' => 'Updated Medicine',
                'Category' => 'Antibiotic',
                'Price' => 'abc',
                'Stock' => 120,
                'low_stock_threshold' => 5,
                'dosage_form' => 'Tablet',
                'strength' => '250mg',
                'is_active' => 1,
            ]);

        $response->assertRedirect(route('admin.medicine.edit', $medicine->medicine_id));
        $response->assertSessionHasErrors('Price');
    }

    /** @test */
    public function test_stock_must_not_be_negative_on_edit()
    {
        $this->loginAdmin();
        $medicine = $this->createMedicine();

        $response = $this->from(route('admin.medicine.edit', $medicine->medicine_id))
            ->put(route('admin.medicine.update', $medicine->medicine_id), [
                'Name' => 'Updated Medicine',
                'Category' => 'Antibiotic',
                'Price' => 75,
                'Stock' => -5,
                'low_stock_threshold' => 5,
                'dosage_form' => 'Tablet',
                'strength' => '250mg',
                'is_active' => 1,
            ]);

        $response->assertRedirect(route('admin.medicine.edit', $medicine->medicine_id));
        $response->assertSessionHasErrors('Stock');
    }

    /** @test */
    public function test_dosage_form_must_be_valid_on_edit()
    {
        $this->loginAdmin();
        $medicine = $this->createMedicine();

        $response = $this->from(route('admin.medicine.edit', $medicine->medicine_id))
            ->put(route('admin.medicine.update', $medicine->medicine_id), [
                'Name' => 'Updated Medicine',
                'Category' => 'Antibiotic',
                'Price' => 75,
                'Stock' => 120,
                'low_stock_threshold' => 5,
                'dosage_form' => 'Cream', // invalid
                'strength' => '250mg',
                'is_active' => 1,
            ]);

        $response->assertRedirect(route('admin.medicine.edit', $medicine->medicine_id));
        $response->assertSessionHasErrors('dosage_form');
    }
}
