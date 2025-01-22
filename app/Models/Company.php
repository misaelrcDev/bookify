<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Cashier\Billable;

class Company extends Model
{

    use Billable;

    protected $fillable = ['name'];
    public function users() {
        return $this->hasMany(User::class);
    }

    public function bookings() {
        return $this->hasMany(Booking::class);
    }
}
