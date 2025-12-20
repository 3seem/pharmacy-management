<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class price_change_log extends Model
{
    //
    protected $table = 'price_change_log';
    protected $primaryKey = 'log_id';
    public function medicine()
    {
        return $this->belongsTo(Medicine::class, 'medicine_id', 'medicine_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'changed_by', 'id');  
    }
}
