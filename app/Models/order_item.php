<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class order_item extends Model
{
    protected $table = 'order_items';

    // Composite primary key - disable auto-incrementing
    public $incrementing = false;

    protected $fillable = [
        'Order_ID',
        'medicine_id',
        'Quantity',
        'unit_price',
        'subtotal',
        'batch_number',
    ];

    protected $casts = [
        'Quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    /**
     * Find a record by composite key
     */
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
    public static function deleteComposite($orderId, $medicineId)
    {
        return self::where('Order_ID', $orderId)
            ->where('medicine_id', $medicineId)
            ->delete();
    }

    /**
     * Relation with medicine
     */
    public function medicine()
    {
        return $this->belongsTo(Medicine::class, 'medicine_id', 'medicine_id');
    }

    /**
     * Relation with order
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'Order_ID', 'Order_ID');
    }
}
