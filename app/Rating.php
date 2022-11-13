<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable = [
        'rating',
        'user_id',
        'ratingable_id',
        'ratingable_type'
    ];
    /**
     * Get all of the owning commentable models.
     */
    public function ratingable()
    {
        return $this->morphTo();
    }
}
