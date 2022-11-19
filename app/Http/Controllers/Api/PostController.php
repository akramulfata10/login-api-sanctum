<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PostController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $posts = Post::latest()->get();
        return response()->json([
            'data' => PostResource::collection($posts),
            'message' => 'Post all View',
            'success' => true,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $validateData = Validator::make($request->all(), [
            'title' => 'required|string|max:155',
            'content' => 'required',
            'status' => 'required',
        ]);

        if ($validateData->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validateData->errors(),
                'success' => false,
            ]);
        }

        $post = Post::create([
            'title' => $request->get('title'),
            'content' => $request->get('content'),
            'status' => $request->get('status'),
            'slug' => Str::slug($request->get('title')),
        ]);

        return response()->json([
            'data' => new PostResource($post),
            'message' => 'Post added Successfuly',
            'success' => true,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post) {
        return response()->json([
            'data' => new PostResource($post),
            'message' => 'Post added Successfuly',
            'success' => true,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post) {
        $validateData = Validator::make($request->all(), [
            'title' => 'required|string|max:155',
            'content' => 'required',
            'status' => 'required',
        ]);

        if ($validateData->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validateData->errors(),
                'success' => false,
            ]);
        }

        $post->update([
            'title' => $request->get('title'),
            'content' => $request->get('content'),
            'status' => $request->get('status'),
            'slug' => Str::slug($request->get('title')),
        ]);

        return response()->json([
            'data' => new PostResource($post),
            'message' => 'updated post successfully',
            'success' => true,
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post) {
        $post->delete();
        return response()->json([
            'data' => [],
            'message' => 'deleted post successfully',
            'success' => true,
        ]);
    }
}