<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;



class Post extends Model
{

    use Sluggable;

    public function category()
    {
    	return $this->hasOne(Category::class);
    }

    public function author()
    {
    	return $this->hasOne(User::class)
    }

    public function tags()
    {
        return $this->belongsToMany(
              Tag::class,  // coonect with model Tag
              'posts_tags', //coonect with table posts_tags
               'post_id', //what connect
               'tag_id' // with what connect
        	)	 
 
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
