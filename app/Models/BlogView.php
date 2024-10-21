<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogView extends Model
{
    protected $table = 'blog_views';
      protected $fillable = ['blog_id', 'vistor_id'];


    public function blogs()
{
    return $this->belongsTo(Blog::class);

}
public function users()
    {
        return $this->belongsTo(User::class,'id');
    }

    
}
