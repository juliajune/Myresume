<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function category()
    {
    	return $this->hasOne(Category::class);
    }

    public function author()
    {
    	return $this->hasOne(User::class)
    }

    public function tags()
        return $this->belongsToMany(
              Tag::class,  // coonect with model Tag
              'posts_tags', //coonect with table posts_tags
               'post_id',
               'tag_id'
        	)	 
 
    	


    	)
    {
    	
    }
}
