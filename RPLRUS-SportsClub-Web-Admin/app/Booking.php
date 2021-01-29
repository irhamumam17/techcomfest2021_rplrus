<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id', 'field_id', 'time', 'total_price', 'date'
    ];

    public function user(){
      return $this->belongsTo("App\User");
    }

    public function field(){
      return $this->belongsTo("App\Field");
    }
}
