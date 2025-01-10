<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Events\BookingCreated;
use Illuminate\Support\Facades\Log;

class Booking extends Model
{
    protected $fillable = [
        'client_name',
        'client_email',
        'service',
        'start_time',
        'end_time',
        'service_id',
        'user_id'
    ];

    protected $dispatchesEvents = [ 
        'created' => BookingCreated::class, 
    ];

    protected static function booted() { 
        static::created(function ($booking) { 
            Log::info("Evento BookingCreated disparado para: {$booking->client_email}"); 
        });
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

}
