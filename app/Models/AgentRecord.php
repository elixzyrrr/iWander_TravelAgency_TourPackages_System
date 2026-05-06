<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AgentRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'created_by',
        'module',
        'reference_code',
        'title',
        'cover_image',
        'contact_name',
        'contact_email',
        'contact_phone',
        'destination',
        'travel_type',
        'travel_start',
        'travel_end',
        'amount',
        'status',
        'description',
        'details',
        'flight_record_id',
        'hotel_record_id',
    ];

    protected function casts(): array
    {
        return [
            'travel_start' => 'date',
            'travel_end' => 'date',
            'amount' => 'decimal:2',
            'details' => 'array',
            'flight_record_id' => 'integer',
            'hotel_record_id' => 'integer',
        ];
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function airlineOptions(): HasMany
    {
        return $this->hasMany(AirlineOption::class);
    }

    public function hotelRoomOptions(): HasMany
    {
        return $this->hasMany(HotelRoomOption::class);
    }

    public function tourDateOptions(): HasMany
    {
        return $this->hasMany(TourDateOption::class);
    }
}
