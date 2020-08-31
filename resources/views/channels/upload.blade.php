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
                            <div class="progress-bar progress-bar-striped progress-bar-animated" :style="{ width: `${video.percentage || progress[video.name]}%` }">
                                @{{ video.percentage ? (video.percentage === 100 ? 'Video processing completed.' : 'Processing') : 'Uploading' }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div v-if="!video.thumbnail" class="d-flex justify-content-center align-items-center" style="height: 180px; color: white; font-size: 18px;background-color: #333">
                                    Loading thumbnail...
                                </div>
                                <img v-else :src="video.thumbnail" style="width: 100%;" />
                            </div>
                            <div class="col-md-4">
                                <a v-if="video.percentage && video.percentage === 100" :href="`/videos/${video.id}`" target="_blank">
                                    @{{ video.title || video.name }}
                                </a>
                                <h4 v-else class="text-center">
                                    @{{ video.title || video.name }}
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
