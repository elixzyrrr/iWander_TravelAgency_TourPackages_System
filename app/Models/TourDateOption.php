<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TourDateOption extends Model
{
    protected $table = 'tour_date_options';
    
    protected $fillable = [
        'agent_record_id',
        'departure_date',
        'return_date',
        'group_size',
        'available_slots',
        'price_per_person',
        'tour_description',
        'included_items',
        'excluded_items',
        'sort_order',
    ];

    protected $casts = [
        'departure_date' => 'date',
        'return_date' => 'date',
        'included_items' => 'array',
        'excluded_items' => 'array',
        'price_per_person' => 'decimal:2',
        'available_slots' => 'integer',
        'group_size' => 'integer',
        'sort_order' => 'integer',
    ];

    public function agentRecord()
    {
        return $this->belongsTo(AgentRecord::class);
    }
}
