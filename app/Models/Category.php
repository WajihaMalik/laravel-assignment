<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'slug'];

    /**
     * Mutator to auto-generate slug.
     */
    protected function slug(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => $value ?: Str::slug($this->name)
        );
    }
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }
}
