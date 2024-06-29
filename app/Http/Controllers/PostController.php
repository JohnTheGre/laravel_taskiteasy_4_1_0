<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of Posts.
     */
    public function index()
    {
        return view('posts.index', [
            'posts' => Post::all()
        ]);
    }

    /**
     * Show the form for creating a new Post.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created Post in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'title' => 'required',
            'excerpt' => 'required',
            'body' => 'required',
        ]);

        // Create a new Post model object, mass-assign its attributes with
        // the validated data and store it to the database
        $post = Post::create($validated);

        // Redirect to the blog index page
        return redirect()->route('posts.index');
    }

    /**
     * Display the specified Post.
     */
    public function show(Post $post)
    {
        $comments = $post->comments()->paginate(10);
        return view('posts.show', [
            'post' => $post,
            'comments' => $comments,
        ]);
    }

    /**
     * Show the form for editing the specified Post.
     */
    public function edit(Post $post)
    {
        return view('posts.edit', [
            'post' => $post
        ]);
    }

    /**
     * Update the specified Post in storage.
     */
    public function update(Request $request, Post $post)
    {
        // Validate the request
        $validated = $request->validate([
            'title' => 'required',
            'excerpt' => 'required',
            'body' => 'required',
        ]);

        // Use `update` to mass (re)assign updated attributes
        $post->update($validated);

        // Redirect to the blog show page
        return redirect()->route('posts.show', $post)
            ->with('success', 'Post successfully updated');
    }

    /**
     * Show the form for deleting the specified Post.
     */
    public function delete(Post $post)
    {
        return view('posts.delete', [
            'post' => $post
        ]);
    }

    /**
     * Remove the specified Post from storage.
     */
    public function destroy(Post $post)
    {
        // Delete the post from the database
        $post->delete();

        // Redirect to the blog show page
        return redirect()->route('posts.index')
            ->with('success', 'Post successfully deleted');
    }

    /**
     * Store a comment for the specified Post.
     */
    public function storeComment(Request $request, Post $post)
    {
        // Check if the user is a Post Viewer
        if (Auth::user()->role !== 'post_viewer') {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'content' => 'required',
        ]);

        $post->comments()->create([
            'content' => $request->content,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('posts.show', $post);
    }


}
