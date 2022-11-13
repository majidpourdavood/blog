<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{

    protected $guarded = ['id'];

    public function itemable()
    {
        return $this->morphTo();
    }
}
