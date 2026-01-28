<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    //
    public $timestamps = false;
    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }
   
    public function conversations()
        {
            return $this->hasMany(Conversation::class);
        }

}
