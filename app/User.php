<?php

namespace App;

use App\Model\Blog;
use App\Model\File;
use App\Model\Like;
use App\Traits\HasPermissionsTrait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, HasPermissionsTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'active',
        'lastName',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id', 'id');
    }


    public function blogs()
    {
        return $this->hasMany(Blog::class, 'user_id');
    }


    public function ratings()
    {
        return $this->morphMany(Rating::class, 'ratingable');
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }


    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }


}
