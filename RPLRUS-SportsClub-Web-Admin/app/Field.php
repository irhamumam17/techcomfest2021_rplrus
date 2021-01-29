<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
  public function bookings(){
    return $this->hasMany("App\Booking");
  }

  public function schedules(){
    return $this->hasMany("App\Schedule");
  }
}
