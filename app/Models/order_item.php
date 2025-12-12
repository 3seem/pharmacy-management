<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class order_item extends Model
{
    //
    
    // no single primary key
    protected $fillable = [
        'Order_ID',
        'medicine_id',
        'Quantity',
        'unit_price',
        'subtotal',
        'batch_number ',
    ];
    public static function findComposite($orderId, $medicineId)
    {
        return self::where('Order_ID', $orderId)
            ->where('medicine_id', $medicineId)
            ->first();
    }

    /**
     * Create a new record
     */
    public static function createComposite($data)
    {
        // $data should include 'Order_ID' and 'medicine_id'
        return self::create($data);
    }

    /**
     * Update a record by composite key
     */
    public static function updateComposite($orderId, $medicineId, $data)
    {
        return self::where('Order_ID', $orderId)
            ->where('medicine_id', $medicineId)
            ->update($data);
    }

    /**
     * Delete a record by composite key
     */
    public function deleteComposite()
    {
        return self::where('Order_ID', $this->Order_ID)
            ->where('medicine_id', $this->medicine_id)
            ->delete();
    }
    public function medicine()
    {
        return $this->belongsTo(medicine::class, 'medicine_id', 'medicine_id');
    }
}
