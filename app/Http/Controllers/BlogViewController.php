<?php

namespace App\Http\Controllers;

use App\Http\Resources\ViewResource;
use App\Models\User;
use App\Models\Blog;
use App\Models\BlogView;
use Illuminate\Http\Request;

class BlogViewController extends Controller
{
    public function show(Blog $blog)
    {
        $totalRaeds = $blog->Views()->count();
        $blog->load('Views');
        return response()->json([
            'blog' => new ViewResource($blog),
            'totalRaeds' => $totalRaeds
        ]);
    }

    public function index()
    {
        $views = Blog::with('Views')->withCount('Views')->get();
        $views = $views->sortByDesc('blog_view_count')->take(10);
        return ViewResource::collection($views->load('Views'));
    }

    public function store(Request $request, $blogId)
    {
        $userId = $request->user()->id;
        $viewExists = BlogView::where('vistor_id', $userId)
            ->where('blog_id', $blogId)
            ->first();
        if ($viewExists) {
            return response()->json(['message' => 'You have already view this blog'], 403);
        }
        BlogView::create([
            'vistor_id' => $userId,
            'blog_id' => $blogId,
        ]);
        return response()->json(['message' => 'View Blog successfully']);
    }
}
