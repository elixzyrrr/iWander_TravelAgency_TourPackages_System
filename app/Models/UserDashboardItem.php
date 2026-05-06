<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserDashboardItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_dashboard_section_id',
        'title',
        'description',
        'image_url',
        'price',
        'currency',
        'meta',
        'sort_order',
        'is_featured',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'meta' => 'array',
            'sort_order' => 'integer',
            'is_featured' => 'boolean',
        ];
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(UserDashboardSection::class, 'user_dashboard_section_id');
    }
}