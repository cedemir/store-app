<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'body',
        'slug',
        'is_active',
        'in_stock',
        'price'
    ];

    public function photos(): HasMany
    {
        return $this->hasMany(ProductPhoto::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * Accessors
     */
    public function thumb(): Attribute
    {
        return new Attribute(get: fn($value) => $this->photos?->first()?->photo);
    }

    public function price(): Attribute
    {
        return new Attribute(
            get: fn($value) => $value / 100,
            set:  fn($value) => (int) round($value * 100)
        );
    }
}
