<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Feedback extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'user_id', 'comment', 'rating'];

     /**
     * Get the product that owns the feedback.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the user that owns the feedback.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
