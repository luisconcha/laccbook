<?php

namespace LaccBook\Models;

use Collective\Html\Eloquent\FormAccessible;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use LaccUser\Models\User;
use LaccBook\Models\Category;

class Book extends Model
{
    use FormAccessible, SoftDeletes;

    protected $fillable = [
        'title', 'subtitle', 'price' ,'author_id','category_id'
    ];

    public function author()
    {
        return $this->belongsTo( \LaccUser\Models\User::class );
    }

    public function categories()
    {
        return $this->belongsToMany( Category::class )->withTrashed();
    }

    public function formCategoriesAttribute()
    {
        return $this->categories->pluck( 'id' )->all();
    }
}
