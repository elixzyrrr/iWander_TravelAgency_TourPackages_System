<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserDashboardBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_dashboard_section_id',
        'user_dashboard_item_id',
        'agent_record_id',
        'booking_type',
        'reference_code',
        'origin',
        'destination',
        'start_date',
        'end_date',
        'travelers',
        'rooms',
        'budget',
        'amount',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'travelers' => 'integer',
            'rooms' => 'integer',
            'budget' => 'decimal:2',
            'amount' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(UserDashboardSection::class, 'user_dashboard_section_id');
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(UserDashboardItem::class, 'user_dashboard_item_id');
    }

    public function agentRecord(): BelongsTo
    {
        return $this->belongsTo(AgentRecord::class, 'agent_record_id');
    }
}