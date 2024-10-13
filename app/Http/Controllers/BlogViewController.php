<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Blog;
use App\Models\BlogView;
use Illuminate\Http\Request;

class BlogViewController extends Controller
{
    public function blogViews(Request $request, $blog_id){
        $userId=$request->user()->id;
        $viewExists =BlogView::where('vistor_id', $userId)
        ->where('blog_id', $blog_id)
        ->first();
    
           if ($viewExists) {
           return response()->json(['message' => 'You have already view this blog'], 403);
             }
             BlogView::create([
               'vistor_id' => $userId,
                'blog_id' => $blog_id,
            ]);
    
              return response()->json(['message' => 'View Blog successfully']);
              }
    
    
    
    
    
     


    public function showBlogViews($id){
        $blogView =Blog::with('BlogViews')->find($id);
    
        if(!$blogView){
            return response()->json(['message'=>'blog not found'],404);
        }
    
        $totalRaeds= $blogView->BlogViews()->count();
        return response()->json([
            'blog'=>$blogView,
            'total_raeds'=>$totalRaeds,
        ]);
    
    }


    public function showRankRaeds(){
        $blogsRankReaed =Blog::with('BlogViews')->withCount('BlogViews')->get();//to count relation blogview and get it
      
        
        $blogsRankReaed=$blogsRankReaed->sortByDesc('blog_view_count')->take(10); //to sorted by desc and take top 10
    
        return response()->json([  //the response
         'blog'=>$blogsRankReaed,
        ]);
    }
}
