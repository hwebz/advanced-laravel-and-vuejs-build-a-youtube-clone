<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Video;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(Video $video) {
        return $video->comments()->paginate(5);
    }

    public function show(Comment $comment) {
        return $comment->replies()->paginate(10);
    }

    public function store(Request $request, Video $video) {
        return auth()->user()->comments()->create([
            'body' => $request->body,
            'comment_id' => $request->comment_id,
            'video_id' => $video->id
        ])->fresh();
        // fresh() to load all relationship after created
    }
}
