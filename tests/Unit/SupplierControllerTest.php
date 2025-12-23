<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Controllers\Suplliers;
use App\Models\supplier;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Mockery;
use PHPUnit\Framework\Attributes\DataProvider;

class SupplierControllerTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /**
     * Data provider (test-case table)
     */
    public static function supplierUpdateCases(): array
    {
        return [

            // ===== VALID CASES =====
            'TC1 valid all fields' => [
                'Updated Supplier',
                'test@example.com',
                '0100000000',
                'Ahmed',
                'Cairo',
                'Giza',
                1,
                true
            ],

            'TC2 valid without email' => [
                'Updated Supplier',
                null,
                null,
                null,
                null,
                null,
                1,
                true
            ],

            'TC3 valid email empty' => [
                'Updated Supplier',
                '',
                null,
                null,
                null,
                null,
                1,
                true
            ],

            // ===== INVALID NAME =====
            'TC4 empty name' => [
                '',
                'test@example.com',
                null,
                null,
                null,
                null,
                1,
                false
            ],

            'TC5 name too long' => [
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
            'TC6 invalid email format' => [
                'Updated Supplier',
                'invalid-email',
                null,
                null,
                null,
                null,
                1,
                false
            ],

            // ===== INVALID PHONE =====
            'TC7 phone too long' => [
                'Updated Supplier',
                'test@example.com',
                str_repeat('1', 40),
                null,
                null,
                null,
                1,
                false
            ],

            // ===== INVALID CONTACT PERSON =====
            'TC8 contact person too long' => [
                'Updated Supplier',
                'test@example.com',
                null,
                str_repeat('A', 300),
                null,
                null,
                1,
                false
            ],

            // ===== INVALID CITY =====
            'TC9 city too long' => [
                'Updated Supplier',
                'test@example.com',
                null,
                null,
                null,
                str_repeat('C', 200),
                1,
                false
            ],

            // ===== INVALID IS_ACTIVE =====
            'TC10 is_active missing' => [
                'Updated Supplier',
                'test@example.com',
                null,
                null,
                null,
                null,
                null,
                false
            ],

            'TC11 is_active not boolean' => [
                'Updated Supplier',
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

    #[DataProvider('supplierUpdateCases')]
    public function test_supplier_update_cases(
        $name,
        $email,
        $phone,
        $person,
        $address,
        $city,
        $isActive,
        $shouldPass
    ) {
        // Instance mock (update is NOT static)
        $mockSupplier = Mockery::mock(supplier::class);

        if ($shouldPass) {
            $mockSupplier->shouldReceive('update')
                ->once()
                ->with([
                    'Supplier_Name'  => $name,
                    'email'          => $email,
                    'Contact_Phone'  => $phone,
                    'Contact_Person' => $person,
                    'address'        => $address,
                    'city'           => $city,
                    'is_active'      => $isActive,
                ]);
        } else {
            $this->expectException(ValidationException::class);
        }

        $request = Request::create('/dummy', 'PUT', [
            'Supplier_Name'  => $name,
            'email'          => $email,
            'Contact_Phone'  => $phone,
            'Contact_Person' => $person,
            'address'        => $address,
            'city'           => $city,
            'is_active'      => $isActive,
        ]);

        $controller = new Suplliers();
        $controller->update($request, $mockSupplier);

        // Prevent "risky test" warning
        if ($shouldPass) {
            $this->assertTrue(true);
        }
    }
}
