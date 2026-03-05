<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    const ROLE_SUPER_ADMIN     = 'super_admin';
    const ROLE_WEDDING_PLANNER = 'wedding_planner';
    const ROLE_FINANCE         = 'finance';
    const ROLE_VENDOR          = 'vendor';
    const ROLE_CLIENT          = 'client';

    protected $fillable = [
        'name', 'email', 'password', 'role',
        'phone', 'avatar', 'address', 'is_active',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'is_active'         => 'boolean',
        ];
    }

    // Role helpers
    public function isSuperAdmin(): bool    { return $this->role === self::ROLE_SUPER_ADMIN; }
    public function isPlanner(): bool       { return $this->role === self::ROLE_WEDDING_PLANNER; }
    public function isFinance(): bool       { return $this->role === self::ROLE_FINANCE; }
    public function isVendorUser(): bool    { return $this->role === self::ROLE_VENDOR; }
    public function isClient(): bool        { return $this->role === self::ROLE_CLIENT; }
    public function isAdmin(): bool         { return in_array($this->role, [self::ROLE_SUPER_ADMIN, self::ROLE_WEDDING_PLANNER, self::ROLE_FINANCE]); }

    public function getDashboardRoute(): string
    {
        return match($this->role) {
            self::ROLE_SUPER_ADMIN, self::ROLE_WEDDING_PLANNER, self::ROLE_FINANCE => 'admin.dashboard',
            self::ROLE_CLIENT => 'client.dashboard',
            default => 'home',
        };
    }

    // Relationships
    public function weddings()          { return $this->hasMany(Wedding::class, 'client_id'); }
    public function assignedWeddings()  { return $this->hasMany(Wedding::class, 'planner_id'); }

    public function getActiveWeddingAttribute(): ?Wedding
    {
        return $this->weddings()->whereIn('status', ['active', 'planning'])->latest()->first();
    }
}
