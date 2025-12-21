<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Order extends Model
{
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
    // relation with customer
    public function customer()
    {
        return $this->belongsTo(User::class, 'Customer_ID', 'id');
    }
    // relation with employee
    public function employee()
    {
        return $this->belongsTo(User::class, 'Employee_ID', 'id');
    }
    public function items()
    {
        return $this->hasMany(order_item::class, 'Order_ID', 'Order_ID');
        // 'Order_ID' => column in order_items table
        // 'id'       => column in orders table
    }

    // public function product()
    // {
    //     return $this->belongsTo(Product::class);
    // }
}
