<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilterPostRequest;
use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Services\FilterPostService;
use Illuminate\Http\Request;

class PostController extends Controller
{
    protected $filterPostService;

    public function __construct(FilterPostService $filterPostService)
    {
        $this->middleware('auth:sanctum', ['except' => ['show', 'index']]);

        $this->authorizeResource(Post::class, 'post');

        $this->filterPostService = $filterPostService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(FilterPostRequest $request)
    {
        $postQuery = $this->filterPostService->execute($request);
        return PostResource::collection($postQuery->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        $post = auth()->user()->posts()->create(
            $request->validated(),
        );

        return new PostResource($post);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return new PostResource($post->load('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, Post $post)
    {
        $post->update(
            $request->validated(),
        );

        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }
}
