<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserDashboardSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'nav_label',
        'nav_icon',
        'title',
        'subtitle',
        'section_type',
        'body',
        'sort_order',
        'is_searchable',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
            'is_searchable' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function items(): HasMany
    {
        return $this->hasMany(UserDashboardItem::class)->orderBy('sort_order');
    }
}