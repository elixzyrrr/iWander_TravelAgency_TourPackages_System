<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HotelRoomOption extends Model
{
    protected $table = 'hotel_room_options';
    
    protected $fillable = [
        'agent_record_id',
        'room_type',
        'capacity',
        'available_rooms',
        'price_per_night',
        'room_description',
        'amenities',
        'sort_order',
    ];

    protected $casts = [
        'amenities' => 'array',
        'price_per_night' => 'decimal:2',
        'available_rooms' => 'integer',
        'capacity' => 'integer',
        'sort_order' => 'integer',
    ];

    public function agentRecord()
    {
        return $this->belongsTo(AgentRecord::class);
    }
}
