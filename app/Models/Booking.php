<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = ['client_name', 'service', 'start_time', 'end_time', 'service_id'];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

}
