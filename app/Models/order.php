<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
            public function items()
        {
            return $this->hasMany(OrderItem::class);
        }

        public function product()
        {
            return $this->belongsTo(Product::class);
        }
}
