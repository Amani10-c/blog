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
  public function show(Blog $blog)
  {
    $totalLikes = $blog->likes()->count();
    $blog->load('likes');
    return response()->json([
      'blog'=>new LikeResource($blog),
      'total_Likes'=>$totalLikes
    ]);
    
  }

  public function store(Request $request, Blog $blog)
  {
    $userId = $request->user()->id;
    $LikeExists = Like::where('user_id', $userId)
      ->where('blog_id', $blog->id)
      ->first();
    if ($LikeExists) {
      return response()->json(['message' => 'You have already like this blog'], 403);
    }
    Like::create([
      'user_id' => $request->user()->id,
      'blog_id' => $blog->id,
    ]);
    return response()->json(['message' => 'Blog liked successfully']);
  }

  public function showRankLike()
  {
    $blogsRankLike = Blog::with('likes')->withCount('likes')->get();
    $blogsRankLike = $blogsRankLike->sortByDesc('like_count')->take(10);
    return LikeResource::collection($blogsRankLike->load('likes'));
  }

  public function destroy(Like $id)
  {
    $id->delete();
    return response()->json([
      'message' => 'delet succsses',
    ]);
  }
}
