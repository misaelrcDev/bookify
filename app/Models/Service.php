<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    protected $fillable = ['name', 'price', 'user_id'];

    use SoftDeletes;

    protected static function booted()
    {
        static::deleting(function ($service) {
            // Remove todas as reservas associadas ao serviço
            $service->reservations()->delete();
        });
    }

    public function reservations()
    {
        return $this->hasMany(Booking::class);
    }
}
