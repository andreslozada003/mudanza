<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Driver extends Model
{
    protected $fillable = [
        'name',
        'user_id',
        'company',
        'city',
        'department',
        'vehicle_type',
        'vehicle_brand',
        'vehicle_model',
        'vehicle_year',
        'plate_mask',
        'capacity_kg',
        'rating',
        'trips',
        'cancelled_trips',
        'completed_percent',
        'response_minutes',
        'distance_km',
        'base_price',
        'price_per_km',
        'availability',
        'verified_identity',
        'verified_license',
        'verified_vehicle',
        'soat_active',
        'technical_review_active',
        'lat',
        'lng',
        'bio',
    ];

    protected $casts = [
        'rating' => 'decimal:1',
        'distance_km' => 'decimal:1',
        'verified_identity' => 'boolean',
        'verified_license' => 'boolean',
        'verified_vehicle' => 'boolean',
        'soat_active' => 'boolean',
        'technical_review_active' => 'boolean',
    ];

    public function favorites(): HasMany
    {
        return $this->hasMany(DriverFavorite::class);
    }
}
