<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Tag extends Model
{

  use Sluggable;	
    
  public function posts()
        return $this->belongsToMany( // many-to-many
              Post::class,  // coonect with model Post
              'posts_tags', //coonect with table posts_tags
              'tag_id', //what connect
              'post_id' // with what connect
        	)


  public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }      		 


}
