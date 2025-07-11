<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class PostController extends Controller
{
    public function create(Request $req)
    {
        $Validator=Validator::make($req->all(),[
            // 'user_id'=>'required|string|max:20',
            'title'=>'required|string|max:100',
            'content'=>'required|string',
            'image'=>'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'published_at' => 'nullable|date',
        ]);

       if ($Validator->fails()) {
    \Log::error('Validation failed', $Validator->errors()->toArray()); // log exact errors
    return response()->json(['errors' => $Validator->errors()], 422);
}

    $imagePath = null;
    if ($req->hasFile('image')) 
    {
        $imagePath = $req->file('image')->store('posts', 'public');
    }

    $post = Post::create([
        'title' => $req->title,
        'content' => $req->content,
        'image' => $imagePath,
        'user_id' => Auth::id(),
        'published_at' => $req->published_at,
    ]);

        return response()->json(['message' => 'Post created successfully', 'post' => $post], 201);
    }

    public function byAuthor($id)
    {
        $user = User::with('posts')->findOrFail($id);

        return response()->json
        ([
            'user_id' => $user->name,
            'posts' => $user->posts
        ]);
    }

    public function index()
    {
         
        $posts = Post::with('author')->orderBy('created_at', 'desc')->get();

        return response()->json($posts);
    }

    public function update(Request $req, $id)
    {
        $validator = Validator::make($req->all(), [
            'title' => 'required|string|max:100',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'published_at' => 'nullable|date',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    $post = Post::where('id', $id)->where('user_id', auth()->id())->firstOrFail();

    if ($req->hasFile('image')) {
        $imagePath = $req->file('image')->store('posts', 'public');
        $post->image = $imagePath;
    }

        $post->title = $req->title;
        $post->content = $req->content;
        $post->published_at = $req->published_at;
        $post->save();

        return response()->json(['message' => 'Post updated', 'post' => $post]);
    }

    public function destroy($id)
    {
        $post = Post::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $post->delete();

        return response()->json(['message' => 'Post deleted successfully']);
    }


}
