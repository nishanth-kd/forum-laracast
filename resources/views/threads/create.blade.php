@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

        </div>
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">
                    Post Thread
                </div>
                <div class="card-body">
                    <form action="/threads/" method="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <input required type="text" name="title" value="{{ old('title') }}" id="title" cols="2" class="form-control" placeholder="Title" rows="4"/>
                        </div>
                        <div class="form-group">
                            <select required name="channel_id" id="channel_id" cols="2" class="form-control" placeholder="Channel">
                                <option value="-1">Channel</option>
                                @foreach($channels as $channel)
                                <option {{ (old('channel_id') == $channel->id ) ? 'selected' :  '' }} value="{{ $channel->id }}" >{{ $channel->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <textarea required name="body" id="body" cols="2" class="form-control" placeholder="Body" rows="4">{{ old('body') }}</textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Post</button>
                        </div>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
            <br>
            
        </div>
    </div>
</div>
@endsection
