<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'Order_ID';

    protected $fillable = [
        'Order_Date',
        'Total_amount',
        'Payment_method',
        'Status',
        'Customer_ID',
        'Employee_ID',
        'discount_amount',
        'tax_amount',
        'delivery_address',
        'delivery_type',
        'notes',
    ];

    protected $casts = [
        'Order_Date' => 'datetime',
        'Total_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
    ];

    // Relation with customer
    public function customer()
    {
        return $this->belongsTo(User::class, 'Customer_ID', 'id');
    }

    // Relation with employee
    public function employee()
    {
        return $this->belongsTo(User::class, 'Employee_ID', 'id');
    }

    // Relation with order items
    public function items()
    {
        return $this->hasMany(order_item::class, 'Order_ID', 'Order_ID');
    }
}
