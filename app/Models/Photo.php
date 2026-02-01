<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Photo Model - Represents vacation package images.
 *
 * @property int $id
 * @property string $path
 * @property string|null $original_name
 * @property bool $is_main
 * @property int $vacation_id
 */
class Photo extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'photos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'path',
        'original_name',
        'is_main',
        'vacation_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_main' => 'boolean',
    ];

    /**
     * Get the vacation that owns this photo.
     *
     * @return BelongsTo
     */
    public function vacation(): BelongsTo
    {
        return $this->belongsTo(Vacation::class, 'vacation_id');
    }
    /**
     * Get the full URL of the photo.
     * Centralizes logic for external URLs (Seeds) vs Local Storage (Uploads).
     *
     * @return string
     */
    public function getUrlAttribute(): string
    {
        if (filter_var($this->path, FILTER_VALIDATE_URL) || str_starts_with($this->path, 'http')) {
            return $this->path;
        }

        return url('storage/' . $this->path);
    }
}
