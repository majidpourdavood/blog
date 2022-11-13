<?php

namespace App;

use App\Model\Comment;
use App\Model\File;
use App\Model\Item;
use App\Model\LocationMigrate;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $guarded = ['id'];

    public function parent()
    {
        return $this->belongsTo('App\Location', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany('App\Location', 'parent_id', 'id');
    }


    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }


    public function ratings()
    {
        return $this->morphMany(Rating::class, 'ratingable');
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function items()
    {
        return $this->morphMany(Item::class, 'itemable');
    }
}
