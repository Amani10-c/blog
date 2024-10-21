<?php

namespace App\Http\Controllers;

use App\Http\Requests\Blog\CreateBlogRequest;
use App\Http\Requests\Blog\UpdateBlogRequest;
use App\Http\Resources\BlogResource;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\Blog;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class BlogController extends Controller
{

    public function index()
    {
        $blogs = Blog::all();
        return BlogResource::collection($blogs->load('blogs'));
    }

    public function show()
    {
        $blog = auth()->user();
        return response()->json([
            'blog' => new BlogResource($blog->load('blogs')),
        ]);
    }

    public function store(CreateBlogRequest $request)
    {
        $userId = auth()->user()->id;
        $blog = Blog::create([
            'user_id' => $userId,
            'subject' => $request->subject,
            'content' => $request->content,

        ]);
        return response()->json([
            'status' => 200,
            'blog' => $blog,
        ], 200);
    }

    public function update(UpdateBlogRequest $request, Blog $blog)
    {
        $blog->update([
            'subject' => $request->subject,
            'content' => $request->content,
        ]);
        return response()->json([
            'status' => 200,
            'blog' => $blog,
        ], 200);
    }

    public function destroy(Blog $blog)
    {
        $blog->delete();
        return response()->json([
            'status' => 200,
            'message' => "blog delete successfully"
        ], 200);
    }
}
