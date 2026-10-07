<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductPhoto extends Model
{
    /** @use HasFactory<\Database\Factories\ProductPhotoFactory> */
    use HasFactory;

    public $fillable = ['photo'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
