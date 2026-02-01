<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * User Model - Represents application users.
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $rol
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'rol',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Check if user is admin.
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->rol === 'admin';
    }

    /**
     * Check if user is advanced.
     *
     * @return bool
     */
    public function isAdvanced(): bool
    {
        return $this->rol === 'advanced' || $this->rol === 'admin';
    }

    /**
     * Get the vacations created by this user.
     *
     * @return HasMany
     */
    public function vacations(): HasMany
    {
        return $this->hasMany(Vacation::class, 'user_id');
    }

    /**
     * Get the bookings made by this user.
     *
     * @return HasMany
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'user_id');
    }

    /**
     * Get the reviews made by this user.
     *
     * @return HasMany
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'user_id');
    }
}
