<?php

namespace Tests\Feature;

use App\Models\medicine;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MedicineAddTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Helper to log in as an admin user
     */
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

    /** @test */
    public function test_add_medicine_page_can_be_rendered()
    {
        $this->loginAdmin();
        $response = $this->get('/medicine/add');
        $response->assertStatus(200);
        $response->assertSee('Add Medicine');
    }

    /** @test */
    public function test_medicine_can_be_created_without_image()
    {
        $this->loginAdmin();
        $response = $this->post('/medicine/store', [
            'Name' => 'Panadol',
            'Category' => 'Painkiller',
            'Price' => 50,
            'Stock' => 100,
            'Description' => 'Test description',
            'low_stock_threshold' => 10,
            'dosage_form' => 'Tablet',
            'strength' => '500mg',
            'is_active' => 1,
        ]);

        $response->assertRedirect('/medicine');
        $this->assertDatabaseHas('medicines', ['Name' => 'Panadol']);
    }

    /** @test */
    /** @test */
    // public function test_medicine_can_be_created_with_image()
    // {
    //     if (!function_exists('imagecreatetruecolor')) {
    //         $this->markTestSkipped('GD extension is not installed.');
    //         return;
    //     }

    //     $this->loginAdmin();
    //     Storage::fake('public');

    //     $image = UploadedFile::fake()->image('medicine.jpg');

    //     $response = $this->post('/medicine/store', [
    //         'Name' => 'Augmentin',
    //         'Category' => 'Antibiotic',
    //         'Price' => 100,
    //         'Stock' => 50,
    //         'Description' => 'Test description',
    //         'low_stock_threshold' => 5,
    //         'dosage_form' => 'Tablet',
    //         'strength' => '250mg',
    //         'is_active' => 1,
    //         'image_url' => $image,
    //     ]);

    //     $response->assertRedirect('/medicine');
    //     $this->assertDatabaseHas('medicines', ['Name' => 'Augmentin']);
    //     Storage::disk('public')->assertExists('uploads/image_url/' . $image->hashName());
    // }


    /** @test */
    public function test_name_is_required()
    {
        $this->loginAdmin();
        $response = $this->post('/medicine/store', [
            'Category' => 'Painkiller',
            'Price' => 50,
            'Stock' => 10,
            'low_stock_threshold' => 1,
            'dosage_form' => 'Tablet',
            'is_active' => 1,
        ]);

        $response->assertSessionHasErrors('Name');
    }

    /** @test */
    public function test_price_must_be_numeric()
    {
        $this->loginAdmin();
        $response = $this->post('/medicine/store', [
            'Name' => 'Panadol',
            'Category' => 'Painkiller',
            'Price' => 'abc',
            'Stock' => 10,
            'low_stock_threshold' => 1,
            'dosage_form' => 'Tablet',
            'is_active' => 1,
        ]);

        $response->assertSessionHasErrors('Price');
    }

    /** @test */
    public function test_stock_must_not_be_negative()
    {
        $this->loginAdmin();
        $response = $this->post('/medicine/store', [
            'Name' => 'Panadol',
            'Category' => 'Painkiller',
            'Price' => 50,
            'Stock' => -5,
            'low_stock_threshold' => 1,
            'dosage_form' => 'Tablet',
            'is_active' => 1,
        ]);

        $response->assertSessionHasErrors('Stock');
    }

    /** @test */
    public function test_dosage_form_must_be_valid()
    {
        $this->loginAdmin();
        $response = $this->post('/medicine/store', [
            'Name' => 'Panadol',
            'Category' => 'Painkiller',
            'Price' => 50,
            'Stock' => 10,
            'low_stock_threshold' => 1,
            'dosage_form' => 'Cream', // invalid
            'is_active' => 1,
        ]);

        $response->assertSessionHasErrors('dosage_form');
    }

    /** @test */
    public function test_image_must_be_image_type()
    {
        $this->loginAdmin();

        $file = UploadedFile::fake()->create('file.pdf', 100, 'application/pdf');

        $response = $this->post('/medicine/store', [
            'Name' => 'Panadol',
            'Category' => 'Painkiller',
            'Price' => 50,
            'Stock' => 10,
            'low_stock_threshold' => 1,
            'dosage_form' => 'Tablet',
            'is_active' => 1,
            'image_url' => $file,
        ]);

        $response->assertSessionHasErrors('image_url');
    }
}
