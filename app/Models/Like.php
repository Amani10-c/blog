<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Like extends Model
{
    protected $table ='likes';
    protected $fillable = ['user_id', 'blog_id'];

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function blogs()
    {
        return $this->belongsTo(Blog::class);
    }

    public function likes()
{
    return $this->hasMany(Like::class);
}



}


