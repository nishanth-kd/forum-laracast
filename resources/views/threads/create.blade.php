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
                            <input type="text" name="title" id="title" cols="2" class="form-control" placeholder="Title" rows="4"/>
                        </div>
                        <div class="form-group">
                            <select name="channel_id" id="channel_id" cols="2" class="form-control" placeholder="Channel">
                                @foreach($channels as $channel)
                                <option value="{{ $channel->id }}">{{ $channel->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <textarea name="body" id="body" cols="2" class="form-control" placeholder="Body" rows="4"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Post</button>
                    </form>
                </div>
            </div>
            <br>
            
        </div>
    </div>
</div>
@endsection
