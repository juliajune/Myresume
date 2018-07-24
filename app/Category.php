<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function posts()
    {
    	return $this->hasMany(Post::class); //in 1 category has many posts. One-to-many
    }
}
