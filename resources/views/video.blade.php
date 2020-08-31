@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                @if ($video->editable())
                    <form action="{{ route('videos.update', $video->id) }}" method="post">
                        @csrf
                        @method('PUT')
                @endif
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
                                    <h4 class="mt-3">
                                        @if($video->editable())
                                            <input type="text" class="form-control" value="{{ $video->title }}" name="title" />
                                        @else
                                            <span>{{ $video->title }}</span>
                                        @endif
                                    </h4>

                                    {{ $video->views }} {{ str_plural('view', $video->views)}}
                                </div>
                                <votes
                                    :default_votes="{{ $video->votes }}"
                                    owner_id="{{ $video->channel->user_id }}"
                                />
                            </div>

                                <hr>
                                @if($video->editable())
                                    <textarea name="description" id="description" rows="3" class="form-control">{{ $video->description }}</textarea>

                                    <div class="text-right mt-4">
                                        <button class="btn btn-info btn-sm">Update video details</button>
                                    </div>
                                @else
                                    {{ $video->description }}
                                @endif
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
            @if($video->editable())
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
    <link rel="stylesheet" href="https://vjs.zencdn.net/7.4.1/video-js.css" />
    <style>
        .vjs-default-skin {
            width: 100%;
        }
        .thumbs-up, .thumbs-down {
            width: 20px;
            height: 20px;
            cursor: pointer;
            fill: currentColor;
        }
        .thumbs-down-active, .thumbs-up-active {
            color: #3EA6FF;
        }
        .thumbs-down {
            margin-left: 1rem;
        }
    </style>

    <style>
        .w-full {
            width: 100% !important;
        }
        .w-80 {
            width: 80% !important;
        }
    </style>
@endsection

@section('scripts')
    <script src="https://vjs.zencdn.net/7.5.4/video.js"></script>
    <script>
        window.CURRENT_VIDEO = '{{ $video->id }}';
    </script>
    <script src='{{ asset('js/player.js') }}'></script>
@endsection
