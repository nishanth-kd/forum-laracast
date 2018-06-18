@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h3> {{ $thread->title }} </h3>
                        @if(auth()->check() && auth()->id() == $thread->user_id)
                        <p><a href="{{ $thread->path() }}/edit" class="">Edit Thread</a></p>
                        @endif
                    </div>
                    {{ $thread->body }}
                </div>
            </div>
            <hr>
            <h4 class="text-muted">Replies</h4>
            @foreach($replies as $reply)
            <div class="card card-default border-light" style="margin-bottom:10px">
                <div class="card-body text-secondary">
                    <h6 class="card-subtitle mb-2 text-muted" id ="reply-{{ $reply->id }}">
                        <a href="#">{{ $reply->owner->name }}</a> said <a href="#reply-{{ $reply->id }}">{{ $reply->created_at->diffForHumans() }}</a>
                    </h6>
                    {{ $reply->body }}
                    <br>
                </div>
            </div>
            @endforeach
            {{ $replies->links() }}
            <br>
            @if(auth()->check())
            <form action="{{ $thread->path() . '/replies' }}" method="post">
                {{ csrf_field() }}
                <div class="form-group">
                    <textarea name="body" id="body" cols="2" class="form-control" placeholder="Say something..." rows="4"></textarea>
                </div> 
                <button type="submit" class="btn btn-primary">Comment</button>
            </form>
            @else
                Please <a href="{{ route('login') }}">sign in</a> to participate in the discussion.
            @endif
        </div>
        <div class="col-md-4">
            <div class="card card-default">
                <div class="card-body">
                    <p>
                        Posted {{ $thread->created_at->diffForHumans() }} by <a href="#"> {{ $thread->owner->name }}</a> and has {{ $thread->replies_count }} {{ str_plural('comment', $thread->replies_count) }}.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
