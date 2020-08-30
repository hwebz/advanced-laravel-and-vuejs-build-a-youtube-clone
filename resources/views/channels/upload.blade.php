@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <channel-uploads
            inline-template
            :channel="{{ $channel }}"
        >
            <div class="col-md-8">
                <div v-if="!selected" class="card p-3 d-flex justify-content-center align-items-center">
                    <input type="file" multiple id="video-files" ref="videos" style="display: none;" @change="upload">
                    <h3>Start uploading videos to your channel</h3>
                    <button class="btn btn-primary" onclick="document.getElementById('video-files').click()">Start upload</button>
                </div>
                <div class="card p-3" v-else>
                    <div class="my-4" v-for="video in videos">
                        <div class="progress mb-3">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" :style="{ width: `${progress[video.name]}%` }"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="d-flex justify-content-center align-items-center" style="height: 180px; color: white; font-size: 18px;background-color: #333">
                                    Loading thumbnail...
                                </div>
                            </div>
                            <div class="col-md-4">
                                <h4 class="text-center">
                                    @{{ video.name }}
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </channel-uploads>
    </div>
</div>
@endsection
