<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserDashboardProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'home_section_key',
        'trips_count',
        'points',
        'preferred_destination',
        'preferred_travel_style',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'trips_count' => 'integer',
            'points' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}