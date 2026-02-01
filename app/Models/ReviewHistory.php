<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * ReviewHistory Model - Stores previous versions of a review.
 */
class ReviewHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'review_id',
        'content',
        'rating',
    ];

    /**
     * Get the review this history entry belongs to.
     */
    public function review(): BelongsTo
    {
        return $this->belongsTo(Review::class);
    }
}
