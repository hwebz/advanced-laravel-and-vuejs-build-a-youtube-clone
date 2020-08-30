@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <channel-uploads
            inline-template
        >
            <div class="col-md-8">
                <div v-if="!selected" class="card p-3 d-flex justify-content-center align-items-center">
                    <input type="file" id="video-files" ref="videos" style="display: none;" @change="upload">
                    <h3>Start uploading videos to your channel</h3>
                    <button class="btn btn-primary" onclick="document.getElementById('video-files').click()">Start upload</button>
                </div>
                <div class="card p-3" v-else>

                </div>
            </div>
        </channel-uploads>
    </div>
</div>
@endsection
