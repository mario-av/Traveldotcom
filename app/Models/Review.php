<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    /**
     * Get the history of edits for this review.
     *
     * @return HasMany
     */
    public function histories(): HasMany
    {
        return $this->hasMany(ReviewHistory::class)->orderBy('created_at', 'desc');
    }

    /**
     * Check if this review is editable (within the 10-minute window).
     *
     * @return bool
     */
    public function isEditable(): bool
    {
        return \App\Custom\SentComments::isComment($this->id);
    }
}
