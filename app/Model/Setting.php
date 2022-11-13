<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function scopeLang($query){
        $locale = app()->getLocale();
        $query->where('lang', $locale);
        return $query;
    }
}
