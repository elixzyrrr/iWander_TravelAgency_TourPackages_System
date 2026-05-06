<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role', 'status', 'commission_rate', 'credit_limit', 'locked_at'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'locked_at' => 'datetime',
            'commission_rate' => 'decimal:2',
            'credit_limit' => 'decimal:2',
            'password' => 'hashed',
        ];
    }

    public function dashboardProfile(): HasOne
    {
        return $this->hasOne(UserDashboardProfile::class);
    }

    public function dashboardBookings(): HasMany
    {
        return $this->hasMany(UserDashboardBooking::class);
    }

    public function agentRecords(): HasMany
    {
        return $this->hasMany(AgentRecord::class, 'created_by');
    }
}
