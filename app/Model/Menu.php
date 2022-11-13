<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $guarded = ['id'];

    public function parent()
    {
        return $this->belongsTo('App\Model\Menu', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany('App\Model\Menu', 'parent_id', 'id');
    }
    public function scopeLang($query){
        $locale = app()->getLocale();
        $query->where('lang', $locale);
        return $query;
    }

}
