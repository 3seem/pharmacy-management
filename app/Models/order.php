<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
            public function items()
        {
            return $this->hasMany(order_item::class);
        }

        public function product()
        {
            return $this->belongsTo(Product::class);
        }
}
