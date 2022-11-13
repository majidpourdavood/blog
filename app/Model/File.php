<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $guarded = ['id'];

    /**
     * Get all of the owning commentable models.
     */
    public function fileable()
    {
        return $this->morphTo();
    }
}
