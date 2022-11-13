<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OptionProperty extends Model
{
    protected $guarded = ['id'];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }


}
