<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Controllers\medicines;
use App\Models\medicine;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Mockery;
use PHPUnit\Framework\Attributes\DataProvider;

class MedicineUpdateControllerTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public static function updateCases(): array
    {
        return [
            // ===== VALID CASES =====
            'TC1 valid all fields' => [
                'Paracetamol',
                'Painkiller',
                15.5,
                100,
                'For fever',
                10,
                'Tablet',
                '500mg',
                'Acetaminophen',
                'Pharma Inc',
                1,
                true
            ],
            'TC2 valid minimal fields' => [
                'Vitamin C',
                null,
                20,
                50,
                null,
                5,
                'Capsule',
                null,
                null,
                null,
                1,
                true
            ],

            // ===== INVALID NAME =====
            'TC3 empty name' => [
                '',
                'Painkiller',
                15.5,
                100,
                null,
                10,
                'Tablet',
                null,
                null,
                null,
                1,
                false
            ],
            'TC4 name too long' => [
                str_repeat('A', 300),
                'Painkiller',
                15.5,
                100,
                null,
                10,
                'Tablet',
                null,
                null,
                null,
                1,
                false
            ],

            // ===== INVALID PRICE =====
            'TC5 negative price' => [
                'Ibuprofen',
                'Painkiller',
                -10,
                50,
                null,
                5,
                'Capsule',
                null,
                null,
                null,
                1,
                false
            ],

            // ===== INVALID STOCK =====
            'TC6 negative stock' => [
                'Ibuprofen',
                'Painkiller',
                15,
                -5,
                null,
                5,
                'Capsule',
                null,
                null,
                null,
                1,
                false
            ],

            // ===== INVALID LOW STOCK THRESHOLD =====
            'TC7 negative low_stock_threshold' => [
                'Ibuprofen',
                'Painkiller',
                15,
                10,
                null,
                -1,
                'Capsule',
                null,
                null,
                null,
                1,
                false
            ],

            // ===== INVALID DOSAGE FORM =====
            'TC8 invalid dosage form' => [
                'Amoxicillin',
                'Antibiotic',
                25,
                30,
                null,
                5,
                'Powder',
                null,
                null,
                null,
                1,
                false
            ],

            // ===== INVALID IS_ACTIVE =====
            'TC9 is_active not boolean' => [
                'Paracetamol',
                'Painkiller',
                15,
                50,
                null,
                5,
                'Tablet',
                null,
                null,
                null,
                'yes',
                false
            ],

            // ===== TOO LONG FIELDS =====
            'TC10 description too long' => [
                'Paracetamol',
                'Painkiller',
                15,
                50,
                str_repeat('D', 1000),
                5,
                'Tablet',
                null,
                null,
                null,
                1,
                true
            ],
            'TC11 generic_name too long' => [
                'Paracetamol',
                'Painkiller',
                15,
                50,
                null,
                5,
                'Tablet',
                null,
                str_repeat('G', 300),
                null,
                1,
                false
            ],
            'TC12 manufacturer too long' => [
                'Paracetamol',
                'Painkiller',
                15,
                50,
                null,
                5,
                'Tablet',
                null,
                null,
                str_repeat('M', 200),
                1,
                false
            ],
            'TC13 strength too long' => [
                'Paracetamol',
                'Painkiller',
                15,
                50,
                null,
                5,
                'Tablet',
                str_repeat('S', 100),
                null,
                null,
                1,
                false
            ],


            // ===== OPTIONAL FIELDS EMPTY =====
            'TC14 optional fields null' => [
                'Aspirin',
                null,
                10,
                20,
                null,
                0,
                'Tablet',
                null,
                null,
                null,
                1,
                true
            ],
        ];
    }

    #[DataProvider('updateCases')]
    public function test_update(
        $Name,
        $Category,
        $Price,
        $Stock,
        $Description,
        $low_stock_threshold,
        $dosage_form,
        $strength,
        $generic_name,
        $manufacturer,
        $is_active,
        $shouldPass
    ) {
        $mockMedicine = Mockery::mock(medicine::class);

        if ($shouldPass) {
            $mockMedicine->shouldReceive('update')->once()->andReturnTrue();
        } else {
            $this->expectException(ValidationException::class);
        }

        $request = Request::create('/dummy', 'PUT', [
            'Name' => $Name,
            'Category' => $Category,
            'Price' => $Price,
            'Stock' => $Stock,
            'Description' => $Description,
            'low_stock_threshold' => $low_stock_threshold,
            'dosage_form' => $dosage_form,
            'strength' => $strength,
            'generic_name' => $generic_name,
            'manufacturer' => $manufacturer,
            'is_active' => $is_active,
        ]);

        $controller = new medicines();
        $controller->update($request, $mockMedicine);

        if ($shouldPass) $this->assertTrue(true);
    }
}
