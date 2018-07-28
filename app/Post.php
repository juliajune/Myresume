<?php

namespace App;

use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;



class Post extends Model
{

    use Sluggable;

    protected $fillable=['title','content'];
    const IS_DRAFT=0;
    const IS_PUBLIC=1;



    //Connections with other models
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

    //  SEO. Transformation rus to en
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

     // Methods. Work with DB
     //Add post
     public static function add($fields)
     {
     	$post=new static; //create $post - Post class new object
     	$post->fill($fields); //fill in the fields.  $fields - array $fillable
     	$post->user_id=1; // user with admin role
     	$post->save(); // save into DB
     	return $post;
     }

     //Edit post
     public function edit($fields)
     {
     	$post->fill($fields); //fill in the fields.  $fields - array $fillable
     	$post->save(); // save into DB
     }
 
     
     // Delete post
     public function remove()
     {
     	$this->delete();
     }
 
      //upload image 
      public function uploadImage($image)
      {
      	 //if $image is null do nothing
      	 if($image==null) {return;}
         
         //If image already exists, delete it
      	 Storage::delete('uploads/'. $this->image);
      	 //Upload new image
      	 $filename=str_random(10) . '.' . $image->extension();
      	 $image->saveAS('uploads' , $filename); // 'uploads' - path to upload image
      	 $this->image=$filename;
      	 $this->save;
      }

     //Show post image
     public function getImage()
     {
     	 //if image not exist, show default image
     	 if ($this->image==null)
     	 {
     	 	return '/img/no-image.png';
     	 }
         
         //if image exist, show  image
         return '/uploads/'.$this->image;


     }


     
     //Set post category
     public function setCategory($id)
     {
     	 //if category not exist (post without category)
     	 if($id==null) {return;}
     	 //if category exist 
     	 $this->category_id=$id;
     	 $this->save;
     }

     //Set post tags
     public function setTags($ids)
     {
     	 //if tag not exist (post without tag)
     	 if($id==null) {return;}
     	 //if tag exist 
     	 $this->tags()->sync($ids); //synchronize post with tags
     	 
     }

    //Post status Draft or Public

     public function setDraft()
     {
     	$this->status=Post::IS_DRAFT;
     	$this->save();
     }

     public function setPublic()
     {
     	$this->status=Post::IS_PUBLIC;
     	$this->save();
     }

     public function toggleStatus($value)
     {

        // if checkbox not cheked, our post is draft
     	if ($value==null){
     		return $this->setDraft();
     	}
        
        // if checkbox cheked, our post is public
        else {
        	 return $this->setPublic();
        }
     }

    //Post status Featured or Standart
     public function setFeatured()
     {
     	$this->is_featured=1;
     	$this->save();
     }

     public function setStandart()
     {
     	$this->status=is_featured=0;
     	$this->save();
     }

      public function toggleFeatured($value)
     {

        // if checkbox not cheked, our post is draft
     	if ($value==null){
     		return $this->setStandart();
     	}
        
        // if checkbox cheked, our post is public
        else {
        	 return $this->setFeatured();
        }
     }





 }
