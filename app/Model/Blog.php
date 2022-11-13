<?php

namespace App\Model;

use App\Category;
use App\Rating;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Blog extends Model
{

    protected $guarded = ['id'];

    protected $casts = [
        'tags' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }



    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function ratings()
    {
        return $this->morphMany(Rating::class, 'ratingable');
    }
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }
    public function items()
    {
        return $this->morphMany(Item::class, 'itemable');
    }

    public function scopeLang($query){
        $locale = app()->getLocale();
        $query->where('lang', $locale);
        return $query;
    }

    public function scopeFilterBlog($query)
    {

        $title = request('title');
        if (isset($title) && trim($title) != '') {

            $query->where('title', 'like', '%' . $title . '%');
        }


        $category_id = request('category_id');

        if (isset($category_id)) {
            $query->whereHas('category', function ($q) use ($category_id) {
                $q->whereIn('category_id', $category_id);
            });
        }

        $sort = request('sort');

        if ($sort == 1) {


            $query->orderBy('viewCount', 'desc');

        } else if ($sort == 2) {

            $query->withCount(['ratings as average_rating' => function ($query) {
                $query->select(DB::raw('coalesce(avg(rating),0)'));
            }])->orderByDesc('average_rating')->get();

        } else if ($sort == 3) {
            $query->orderBy('created_at', 'desc');

        }

        return $query;
    }

}
