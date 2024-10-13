<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{

    protected $fillable = [
        'subject',
        'content',
        'user_id', 
    ];

    public function users()
    {
        return $this->belongsTo(User::class,'id');
    }
    
    public function likeBlogs(){
        return $this->belongsToMany(User::class, 'likes', 'blog_id', 'user_id')->withTimestamps();
    }


    public function BlogViews(){
        return $this->belongsToMany(User::class,'blog_views','blog_id','vistor_id')->withTimestamps();
    }

   

}