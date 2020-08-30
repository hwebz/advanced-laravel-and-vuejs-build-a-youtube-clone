<?php

namespace App\Http\Controllers;

use App\Channel;
use Illuminate\Http\Request;

class UploadVideoController extends Controller
{
    public function index(Channel $channel) {
        return view('channels.upload', [
            'channel' => $channel
        ]);
    }
}
