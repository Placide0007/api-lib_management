<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::all();

        return response()->json([
            'message' => 'Posts loaded',
            'posts' => PostResource::collection($posts)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        $fields = $request->validated();

        if($request->hasFile('image')){
            $fields['image'] = $request->file('image')->store('images','public');
        }

        $post = Post::create($fields);

        return response()->json([
            'message' => 'Post created successfully',
            'posts' => PostResource::make($post)
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::findOrFail($id);

        return response()->json([
            'message' => 'Post fetched',
            'posts' => PostResource::make($post)]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, string $id)
    {
        $post = Post::findOrFail($id);

        $fields = $request->validated();

        if($request->hasFile('image')){
            if($post->image && Storage::disk('public')->exists($post->image)){
                Storage::disk('public')->delete($post->image);
            }
            $fields['image'] = $request->file('image')->store('images','public');
        }

        $post->update($fields);

        return response()->json([
            'message' => 'Post updated',
            'post' => PostResource::make($post)]
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);

        if($post->image && Storage::disk('public')->exists($post->image) ){
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return response()->json(['message' => 'post deleted successfully']);
    }
}
