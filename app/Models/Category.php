<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Category Model - Represents vacation type categories.
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 */
class Category extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * Get the vacations for this category.
     *
     * @return HasMany
     */
    public function vacations(): HasMany
    {
        return $this->hasMany(Vacation::class, 'category_id');
    }
}
