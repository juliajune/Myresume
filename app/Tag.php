<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    
  public function posts()
        return $this->belongsToMany(
              Post::class,  // coonect with model Post
              'posts_tags', //coonect with table posts_tags
              'tag_id', //what connect
              'post_id' // with what connect
        	)	 


}
