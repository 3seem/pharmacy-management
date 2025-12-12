<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class supplier extends Model
{
    //
    protected $primaryKey = 'Supplier_ID';
    protected $fillable = [
        'Supplier_Name',
        'Contact_Person',
        'Contact_Phone',
        'email',             
        'address',
        'city',
        'country',
        'is_active',
    ];
}
