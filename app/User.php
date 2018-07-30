<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
   
    const IS_BANNED =1;
    const IS_ACTIVE=0;
   



    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


   public function posts()
   {
       return $this->hasMany(Post::class); //1 author has many posts. one-to-many
   }

   public function comments()
   {
       return $this->hasMany(Comment::class); //1 author has many comments. one-to-many
   }


// Methods. Work with DB
public static function add($fields)
{
     $user=new static;  //create new object of User model
     $user->fill($fields); // data from $fillable massive
     $user->password=bcrypt($fields['password']);
     $user->save();
     return $user;
}

public static function edit($fields)
{
     $user->fill($fields); // data from $fillable massive
     $user->password=bcrypt($fields['password']);
     $user->save();
}


public static function remove()
{
     $this->delete();
}


//upload avatar
      public function uploadAvatar($image)
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
        return '/img/no-user-image.png';
       }
         
         //if image exist, show  image
         return '/uploads/'.$this->image;
     }

     public function makeAdmin()
     {
       $this->is_admin=1;
       $this->save();
     }

      public function makeNormal()
     {
       $this->is_admin=0;
       $this->save();
     }

    public function toggleAdmin($value)
    {
       is ($value == null)
       {
        return $this->makeNormal();
       }
        
        return $this->makeAdmin(); 
    }

   //User bun or unban

   public function unban()
    {
       $this->status=User::IS_ACTIVE;
       $this->save();
    }

   public function ban()
    {
       $this->status=User::IS_BANED;
       $this->save();
    }

    public function toggleBan($value)
    {
      
         if($value==null){
             return $This->unban();

          }

          return $this->ban();


    }


















}// User
