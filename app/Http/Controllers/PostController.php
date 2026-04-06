<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
// These 3 imports are REQUIRED for Laravel 12 authorization
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PostController extends Controller implements HasMiddleware
{
    use AuthorizesRequests;

    /**
     * Replaces the old constructor 'authorizeResource'
     */
    public static function middleware(): array
    {
        return [
            // This applies your PostPolicy to the controller actions
            new Middleware('can:viewAny,App\Models\Post', only: ['index']),
            new Middleware('can:view,post', only: ['show']),
            new Middleware('can:create,App\Models\Post', only: ['create', 'store']),
            new Middleware('can:update,post', only: ['edit', 'update']),
            new Middleware('can:delete,post', only: ['destroy']),
        ];
    }

    public function index()
    {
        $posts = Post::with('user')->latest()->paginate(10);
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        $post->update($request->only('title', 'content'));

        return redirect()->route('posts.index')->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }
}