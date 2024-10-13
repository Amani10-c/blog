<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Blog;
use App\Models\BlogView;
use App\Models\Like;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;



class likeConroller extends Controller
{
public function likeBlog(Request $request, $blog_id)
    {
        // Check if the user has already liked the blog
        $likeExists =Like::where('user_id', $request->user()->id)
                              ->where('blog_id', $blog_id)
                              ->exists();
    
        if ($likeExists) {
            return response()->json(['message' => 'You have already liked this blog'], 403);
        }
         // Create a like
         Like::create([
        'user_id' => $request->user()->id,
        'blog_id' => $blog_id,
    ]);

    return response()->json(['message' => 'Blog liked successfully']);
}

  public function showLike($id)
    {
   $blog = Blog::with('likeBlogs')->find($id);

     if (!$blog) {
    return response()->json(['message' => 'Blog not found'], 404);
       }

       $totalLikes = $blog->likeBlogs()->count();
         return response()->json([
           'blog' => $blog,
             'total_likes' => $totalLikes,
          ]);


}

// public function BlogView(Request $request, $blog_id){
//     $userId=$request->user()->id;
//     $viewExists =BlogView::where('vistor_id', $userId)
//     ->where('blog_id', $blog_id)
//     ->first();

//        if ($viewExists) {
//        return response()->json(['message' => 'You have already view this blog'], 403);
//          }
//          BlogView::create([
//            'vistor_id' => $userId,
//             'blog_id' => $blog_id,
//         ]);

//           return response()->json(['message' => 'View Blog successfully']);
//           }





//    public function show($id)
//     {
//     $blog = Blog::with('like')->find($id);

//     if (!$blog) {
//         return response()->json(['message' => 'Blog not found'], 404);
//     }


   
//     $totalLikes = $blog->like()->count();
//     return response()->json([
//         'blog' => $blog,
//         'total_likes' => $totalLikes,
//     ]);

 
// }


// public function showBlogViews($id){
//     $blogView =Blog::with('BlogView')->find($id);

//     if(!$blogView){
//         return response()->json(['message'=>'blog not found'],404);
//     }

//     $totalRaeds= $blogView->BlogView()->count();
//     return response()->json([
//         'blog'=>$blogView,
//         'total_raeds'=>$totalRaeds,
//     ]);

// }
public function showRankLike(){
    $blogsRankLike =Blog::with('likeBlogs')->withCount('likeBlogs')->get();
   
    
     $blogsRankLike= $blogsRankLike->sortByDesc('like_count')->take(10);

  return response()->json([
    'blog' => $blogsRankLike,
    
]);



}
// public function showRankRaeds(){
//     $blogsRankReaed =Blog::with('BlogView')->withCount('BlogView')->get();//to count relation blogview and get it
  
    
//     $blogsRankReaed=$blogsRankReaed->sortByDesc('blog_view_count')->take(10); //to sorted by desc and take top 10

//     return response()->json([  //the response
//      'blog'=>$blogsRankReaed,
//     ]);
// }
}
