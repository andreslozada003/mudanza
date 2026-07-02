<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Conversation extends Model
{
    protected $fillable = [
        'solicitud_id',
        'request_number',
        'cliente_id',
        'conductor_id',
        'status',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'cliente_id');
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class, 'conductor_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }
}
