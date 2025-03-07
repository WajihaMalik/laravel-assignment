<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Casts\Attribute;
class Product extends Model
{
    protected $fillable = ['name', 'description', 'price','stock_quantity', 'stock_status'];

    protected function stockStatus(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => $value === 'in_stock' ? 'In Stock' : 'Out of Stock',
        );
    }
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    /**
     * Get the feedback for the product.
     */
    public function feedback()
    {
        return $this->hasMany(Feedback::class);
    }
}
