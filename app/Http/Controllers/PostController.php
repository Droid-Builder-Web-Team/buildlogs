<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\BuildLog;
use Spatie\Tags\Tag;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tags = Tag::getWithType('posttype');
        return view('posts.create', ['tags' => $tags]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
            'title' => 'required',
            ]
        );

        $userid = $request->user()->id;
        // check userid is owner of build_log_id

        $post['user_id'] = $userid;
        $post['build_log_id'] = $request['build_log_id'];
        $post['title'] = $request['title'];
        $post['post'] = $request['post'];

        try {
            $newpost = Post::create($post);
        } catch (\Illuminate\Database\QueryException $exception) {
            dd($exception);
        }
        $newpost->syncTagsWithType($request['tags'], 'posttype');

        return redirect()->route('buildlogs.show', $request['build_log_id']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
