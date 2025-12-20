<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class medicine extends Model
{
    //
    protected $primaryKey = 'medicine_id';
    protected $fillable = [
        'Name',
        'Description',
        'Price',
        'Stock',              // THIS matches your form
        'Category',
        'low_stock_threshold',
        'generic_name',
        'manufacturer',
        'dosage_form',
        'strength',
        'is_active',
        'image_url',          // MUST BE HERE
    ];
}
