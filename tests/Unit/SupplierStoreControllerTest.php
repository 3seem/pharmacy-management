<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Controllers\Suplliers;
use App\Models\supplier;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Mockery;
use PHPUnit\Framework\Attributes\DataProvider;

class SupplierStoreControllerTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /**
     * Data provider for supplier store cases
     */
    public static function supplierStoreCases(): array
    {
        return [

            // ===== VALID CASES =====
            'TC1 valid all fields' => [
                'Supplier One',
                'test@example.com',
                '0100000000',
                'Ahmed',
                'Cairo Street',
                'Giza',
                1,
                true
            ],

            'TC2 valid without optional fields' => [
                'Supplier Two',
                null,
                null,
                null,
                null,
                null,
                0,
                true
            ],

            // ===== INVALID NAME =====
            'TC3 empty name' => [
                '',
                'test@example.com',
                null,
                null,
                null,
                null,
                1,
                false
            ],

            'TC4 name too long' => [
                str_repeat('A', 300),
                'test@example.com',
                null,
                null,
                null,
                null,
                1,
                false
            ],

            // ===== INVALID EMAIL =====
            'TC5 invalid email format' => [
                'Supplier',
                'invalid-email',
                null,
                null,
                null,
                null,
                1,
                false
            ],

            // ===== INVALID PHONE =====
            'TC6 phone too long' => [
                'Supplier',
                'test@example.com',
                str_repeat('1', 50),
                null,
                null,
                null,
                1,
                false
            ],

            // ===== INVALID CITY =====
            'TC7 city too long' => [
                'Supplier',
                'test@example.com',
                null,
                null,
                null,
                str_repeat('C', 200),
                1,
                false
            ],

            // ===== INVALID IS_ACTIVE =====
            'TC8 is_active missing' => [
                'Supplier',
                'test@example.com',
                null,
                null,
                null,
                null,
                null,
                false
            ],

            'TC9 is_active not boolean' => [
                'Supplier',
                'test@example.com',
                null,
                null,
                null,
                null,
                'yes',
                false
            ],
        ];
    }

    #[DataProvider('supplierStoreCases')]
    public function test_supplier_store_cases(
        $name,
        $email,
        $phone,
        $person,
        $address,
        $city,
        $isActive,
        $shouldPass
    ) {
        // REMOVED ALIAS MOCK - This was causing the "Cannot redeclare" error

        if (!$shouldPass) {
            $this->expectException(ValidationException::class);
        }

        $request = Request::create('/dummy', 'POST', [
            'Supplier_Name'  => $name,
            'email'          => $email,
            'Contact_Phone'  => $phone,
            'Contact_Person' => $person,
            'address'        => $address,
            'city'           => $city,
            'is_active'      => $isActive,
        ]);

        $controller = new Suplliers();
        $response = $controller->store($request);

        // For valid cases, assert success
        if ($shouldPass) {
            $this->assertTrue(true);
            // Or check the response if your controller returns something
            // $this->assertNotNull($response);
        }
    }
}
