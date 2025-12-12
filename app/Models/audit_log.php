<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class audit_log extends Model
{
    //
    protected $table = 'audit_log';
    protected $primaryKey = 'audit_id';
    public function user()
    {
        return $this->belongsTo(User::class, 'changed_by', 'id');
    }
}
