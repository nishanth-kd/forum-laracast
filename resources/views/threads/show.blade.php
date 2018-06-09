@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="d-flex justify-content-between">
                <h3> {{ $thread->title }} </h3>
                @if(auth()->check() && auth()->id() == $thread->user_id)
                <p><a href="{{ $thread->path() }}/edit" class="">Edit Thread</a></p>
                @endif
            </div>
            <h5 class="text-muted">posted by <a href="#"> {{ $thread->owner->name }}</a> </h5>
            <br>
            <div class="card card-default">
                <div class="card-body">
                    {{ $thread->body }}
                </div>
            </div>
            <hr>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h4 class="text-muted">Replies</h4>
            @foreach($thread->replies as $reply)
            <div class="card card-default border-light" style="margin-bottom:10px">
                <div class="card-body text-secondary">
                    <h6 class="card-subtitle mb-2 text-muted" id ="reply-{{ $reply->id }}">
                        <a href="#">{{ $reply->owner->name }}</a> says <a href="#reply-{{ $reply->id }}">{{ $reply->created_at->diffForHumans() }}</a>
                    </h6>
                    {{ $reply->body }}
                    <br>
                </div>
            </div>
            @endforeach
            <br>
        </div>
    </div>

    @if(auth()->check())
    <div class="row justify-content-center">
        <div class="col-md-8">
            <form action="{{ $thread->path() . '/replies' }}" method="post">
                {{ csrf_field() }}
                <div class="form-group">
                    <textarea name="body" id="body" cols="2" class="form-control" placeholder="Say something..." rows="4"></textarea>
                </div> 
                <button type="submit" class="btn btn-primary">Comment</button>
            </form>
        </div>
    </div>
    @else
    <div class="row justify-content-center text-center">
        <div class="col-md-8">
            Please <a href="{{ route('login') }}">sign in</a> to participate in the discussion.
        </div>
    </div>
    @endif
</div>
@endsection
