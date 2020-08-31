@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    {{ $video->title }}
                </div>
                <div class="card-body">
                    <video-js
                        id="my_video_1"
                        class="vjs-default-skin"
                        controls
                        preload="auto"
                        width="640"
                        height="268"
                    >
                        <source src='{{ asset(Storage::url("videos/{$video->id}/{$video->id}.m3u8")) }}' type="application/x-mpegURL" />
                    </video-js>

                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mt-3">
                                {{ $video->title }}
                            </h3>

                            {{ $video->views }} {{ str_plural('view', $video->views)}}
                        </div>
                        <div>

                        </div>
                    </div>
                    <hr>

                    <div class="d-flex justify-content-between align-items-center mt-5">
                        <div class="media">
                            <img class="rounded-circle" src="https://picsum.photos/id/42/200/200" width="50" height="50" class="mr-3" alt="...">
                            <div class="media-body ml-2">
                            <h5 class="mt-0 mb-0">{{ $video->channel->name }}</h5>
                            <span class="small">Published on {{ $video->created_at->toFormattedDateString() }}</span>
                            </div>
                        </div>

                        <subscribe-button
                            :initial-subscriptions="{{ $video->channel->subscriptions }}"
                            :channel="{{ $video->channel }}"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
    <link rel="stylesheet" href="https://vjs.zencdn.net/7.4.1/video-js.css" />
@endsection

@section('scripts')
    <script src="https://vjs.zencdn.net/7.5.4/video.js"></script>
    <script>
        window.CURRENT_VIDEO = '{{ $video->id }}';
    </script>
    <script src='{{ asset('js/player.js') }}'></script>
@endsection
