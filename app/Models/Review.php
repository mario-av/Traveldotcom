<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Review Model - Represents user reviews for vacations.
 *
 * @property int $id
 * @property string $content
 * @property int $rating
 * @property bool $approved
 * @property int $user_id
 * @property int $vacation_id
 */
class Review extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'reviews';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'content',
        'rating',
        'approved',
        'user_id',
        'vacation_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'approved' => 'boolean',
    ];

    /**
     * Get the user who wrote this review.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the vacation for this review.
     *
     * @return BelongsTo
     */
    public function vacation(): BelongsTo
    {
        return $this->belongsTo(Vacation::class, 'vacation_id');
    }
}
