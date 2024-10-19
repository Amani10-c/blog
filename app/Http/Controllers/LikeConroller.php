<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Blog;
use App\Models\BlogView;
use App\Models\Like;
use App\Http\Resources\BlogResource;
use App\Http\Resources\LikeResource;

use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;



class likeConroller extends Controller
{
  public function store(Request $request, Blog $blog)
  {
    Like::create([
      'user_id' => $request->user()->id,
      'blog_id' => $blog->id,
    ]);
    return response()->json(['message' => 'Blog liked successfully']);
  }

  public function show(Blog $blog)
  {
    $totalLikes = $blog->likes()->count();
    return response()->json([
      'blog' => $blog,
      'total_likes' => $totalLikes,
    ]);
  }

  public function showRankLike()
  {
    $blogsRankLike = Blog::with('likeBlogs')->withCount('likeBlogs')->get();
    $blogsRankLike = $blogsRankLike->sortByDesc('like_count')->take(10);
    return response()->json([
      'blog' => $blogsRankLike,

    ]);
  }
  public function destroy(Like $id)
  {
    $id->delete();
    return response()->json([
      'message' => 'delet succsses',
    ]);
  }
}
