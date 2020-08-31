@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    {{ $channel->name }}

                    <a href="{{ route('channel.upload', $channel->id) }}">Upload Videos</a>
                </div>

                <div class="card-body">
                    @if($channel->editable())
                        <form id="update-channel-form" action="{{ route('channels.update', $channel->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                    @endif

                        <div class="form-group row justify-content-center">
                            <div class="channel-avatar">
                                @if($channel->editable())
                                    <div class="channel-avatar-overlay" onclick="document.getElementById('image').click()"></div>
                                @endif
                                <img src="{{ $channel->image() }}" />
                            </div>
                        </div>

                        <div class="form-group">
                            <h4 class="text-center">{{ $channel->name }}</h4>
                            <p class="text-center">{{ $channel->description }}</p>
                        </div>

                        <div class="text-center">
                            <subscribe-button
                                :initial-subscriptions="{{ $channel->subscriptions }}"
                                :channel="{{ $channel }}"
                            />
                        </div>

                        @if($channel->editable())
                            <input onchange="document.getElementById('update-channel-form').submit()" type="file" name="image" id="image" style="display: none;"/>

                            <div class="form-group">
                                <label for="name" class="form-control-label">
                                    Name
                                </label>
                                <input type="text" id="name" name="name" value="{{ $channel->name }}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="description" class="form-control-label">
                                    Description
                                </label>
                                <textarea type="text" id="description" name="description" rows="3" class="form-control">{{ $channel->description }}</textarea>
                            </div>

                            @if($errors->any())
                                <ul class="list-group">
                                    @foreach($errors->all() as $error)
                                        <li class="list-group-item">
                                            {{ $error }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        @endif

                    @if($channel->editable())
                            <button class="btn btn-info">Update Channel</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
