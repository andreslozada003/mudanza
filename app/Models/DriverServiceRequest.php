<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DriverServiceRequest extends Model
{
    protected $fillable = [
        'user_id',
        'driver_id',
        'request_number',
        'origin',
        'destination',
        'weight_kg',
        'vehicle_type',
        'offered_price',
        'status',
        'message',
    ];
}
