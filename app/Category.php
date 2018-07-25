<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Category extends Model
{

	use Sluggable;

    public function posts()
    {
    	return $this->hasMany(Post::class); //in 1 category has many posts. One-to-many
    }


    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
    
}
