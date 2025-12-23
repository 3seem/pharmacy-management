<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Controllers\medicines;
use App\Models\medicine;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Mockery;
use PHPUnit\Framework\Attributes\DataProvider;

class MedicineStoreControllerTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public static function storeCases(): array
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

            // ===== INVALID DOSAGE FORM =====
            'TC7 invalid dosage form' => [
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
            'TC8 is_active not boolean' => [
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
            'TC9 description too long' => [
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
            'TC10 generic_name too long' => [
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
                false // <-- now false
            ],
            'TC11 manufacturer too long' => [
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
                false // <-- now false
            ],

        ];
    }

    #[DataProvider('storeCases')]
    public function test_store(
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
        $medicineMock = Mockery::mock('alias:' . medicine::class);

        if ($shouldPass) {
            $medicineMock->shouldReceive('create')->once()->andReturnTrue();
        } else {
            $this->expectException(ValidationException::class);
        }

        $request = Request::create('/dummy', 'POST', [
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
        $controller->store($request);

        if ($shouldPass) $this->assertTrue(true);
    }
}
