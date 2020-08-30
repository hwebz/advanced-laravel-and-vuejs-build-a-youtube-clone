@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ $channel->name }}
                </div>

                <div class="card-body">
                    <form id="update-channel-form" action="{{ route('channels.update', $channel->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="form-group row justify-content-center">
                            <div class="channel-avatar">
                                <div class="channel-avatar-overlay" onclick="document.getElementById('image').click()"></div>
                                <img src="{{ $channel->image() }}" />
                            </div>
                        </div>

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
                            <textarea type="text" id="description" name="description" rows="3" class="form-control">
                                {{ $channel->description }}
                            </textarea>
                        </div>
                        <button class="btn btn-info">Update Channel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
