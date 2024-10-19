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


    public function show()
    {
        $blog = auth()->user();
        return response()->json([
            'blog' => new BlogResource($blog->load('blog')),
        ]);
    }

    public function index()
    {
        $blogs = Blog::all();
        if ($blogs->count() > 0) {
            return BlogResource::collection($blogs->load('blogs'));
        }
    }

    public function store(CreateBlogRequest $request)
    {
        if (auth()->check()) {
            $userId = auth()->user()->id;
        } else {
            return response()->json(['error' => 'User not authenticated'], 401);
        } {

            $blog = Blog::create([
                'user_id' => $userId,
                'subject' => $request->subject,
                'content' => $request->content,

            ]);
            if ($blog) {
                return response()->json([
                    'status' => 200,
                    'message' => "blog created successfully"
                ], 200);
            }
        }
    }

    public function update(UpdateBlogRequest $request, Blog $blog)
    {
        $blog->subject = $request->subject;
        $blog->content = $request->content;
        $blog->save();
        return response()->json([
            'status' => 200,
            'message' => "blog edit successfully"
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