<?php

namespace App\Models;

use App\Events\BookingCreated;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property string $client_name
 * @property string $client_email
 * @property string $start_time
 * @property string $end_time
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $service_id
 * @property-read \App\Models\Service $service
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereClientEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereClientName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereServiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereUserId($value)
 * @mixin \Eloquent
 */
class Booking extends Model
{
    protected $fillable = [
        'client_name',
        'client_email',
        'service',
        'start_time',
        'end_time',
        'service_id',
        'user_id',
    ];

    protected $dispatchesEvents = [
        'created' => BookingCreated::class,
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
