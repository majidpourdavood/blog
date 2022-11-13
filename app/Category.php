<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = ['id'];

    public function parent()
    {
        return $this->belongsTo('App\Category', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany('App\Category', 'parent_id', 'id');
    }


    public function scopeLang($query){
        $locale = app()->getLocale();
        $query->where('lang', $locale);
        return $query;
    }
}
