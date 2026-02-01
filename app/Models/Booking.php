<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Booking Model - Represents user vacation bookings.
 *
 * @property int $id
 * @property int $num_guests
 * @property float $total_price
 * @property string $status
 * @property string|null $notes
 * @property int $user_id
 * @property int $vacation_id
 */
class Booking extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bookings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'num_guests',
        'total_price',
        'status',
        'notes',
        'user_id',
        'vacation_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'total_price' => 'decimal:2',
    ];

    /**
     * Get the user who made this booking.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the vacation for this booking.
     *
     * @return BelongsTo
     */
    public function vacation(): BelongsTo
    {
        return $this->belongsTo(Vacation::class, 'vacation_id');
    }
}
