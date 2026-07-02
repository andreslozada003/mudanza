<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DriverReport extends Model
{
    protected $fillable = ['user_id', 'driver_id', 'reason', 'description', 'status'];
}
