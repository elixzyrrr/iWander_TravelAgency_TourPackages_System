<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AirlineOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'agent_record_id',
        'airline_name',
        'airline_code',
        'icon',
        'sort_order',
        'flights',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
            'flights' => 'array',
        ];
    }

    public function agentRecord(): BelongsTo
    {
        return $this->belongsTo(AgentRecord::class);
    }
}