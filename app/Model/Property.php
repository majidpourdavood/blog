<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $guarded = ['id'];

    public function optionProperties()
    {
        return $this->hasMany(OptionProperty::class);
    }
    public function scopeLang($query){
        $locale = app()->getLocale();
        $query->where('lang', $locale);
        return $query;
    }

}
