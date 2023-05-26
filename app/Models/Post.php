<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Tag;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    /**
     * guarded
     * 
     * @var array
     */
    protected $guarded = [];

    /**
     * category
     * 
     * @return void
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * tags
     *
     * @return void
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * image
     * 
     * @return Attribute
     */
    protected function image() :Attribute
    {
        return Attribute::make(
            get: fn ($value) => asset('/storage/posts/'. $value)
        );
    }

    /**
     * getCreatedAttribute
     * 
     * @param mixed $date
     */
    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('d-M-Y'),
        );
    }

}
