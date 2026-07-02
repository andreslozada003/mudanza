<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserVerification extends Model
{
    protected $fillable = [
        'user_id',
        'document_type',
        'document_number',
        'document_issued_at',
        'birth_date',
        'gender',
        'city',
        'address',
        'document_front_path',
        'document_back_path',
        'selfie_path',
        'status',
        'observations',
        'verified_at',
    ];

    protected function casts(): array
    {
        return [
            'document_issued_at' => 'date',
            'birth_date' => 'date',
            'verified_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
