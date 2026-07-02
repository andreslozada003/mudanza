<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DriverMessage extends Model
{
    protected $fillable = ['user_id', 'driver_id', 'message', 'read'];
}
