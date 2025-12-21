<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    //
    protected $primaryKey = 'batch_number'; 
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'batch_number',
        'exp_date',
        'mfg_date',
        'quantity',
        'purchase_price',
        'medicine_id',
        'current_stock',
        'cost_per_unit'
    ];

    public function medicine()
    {
        return $this->belongsTo(Medicine::class, 'medicine_id', 'medicine_id');
    }
}
