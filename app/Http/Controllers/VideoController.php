<?php

namespace App\Http\Controllers;

use App\Http\Requests\Videos\UpdateVideoRequest;
use App\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function show(Video $video) {
        if (request()->wantsJson()) {
            return $video;
        }

        return view('video', compact('video'));
    }

    public function updateViews(Video $video) {
        $video->increment('views');

        return response()->json([]);
    }

    public function update(UpdateVideoRequest $request, Video $video) {
        $video->update($request->only(['title', 'description']));

        return redirect()->back();
    }
}
