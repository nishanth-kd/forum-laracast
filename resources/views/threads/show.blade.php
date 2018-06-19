@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card card-default border-light">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h3 class="display-4"> {{ $thread->title }} </h3>
                    </div>
                    {{ $thread->body }}
                    <hr>
                    <div class="action">
                        @can('update', $thread)
                        <a href="{{ $thread->path() }}/edit" class="btn btn-warning"><i class="fas fa-edit"></i> Edit Thread</a>
                        @endcan
                        @can('delete', $thread)
                        <form action="{{ $thread->path() }}" class="d-inline " method="POST">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i> Delete Thread</button>
                        </form>
                        @endcan
                    </div>
                </div>
            </div>
            <hr>
            <h4 class="text-muted"><i class="fas fa-comments"></i> Replies</h4>
            @foreach($replies as $reply)
            <div class="card card-default border-light" style="margin-bottom:10px">
                <div class="card-header border-light text-secondary d-flex justify-content-between" id ="reply-{{ $reply->id }}">
                    <div class="align-middle">
                        <a href="{{ $reply->owner->profile() }}" style="padding: 6px 0;" class="align-middle">{{ $reply->owner->name }}</a> said <a href="#reply-{{ $reply->id }}">{{ $reply->created_at->diffForHumans() }}</a>
                    </div>
                    <div>
                        @if($reply->isFavorited())
                            <div class="text-danger">
                                <span>{{ $reply->favorites_count }}</span> <i class="fas fa-heart"></i>
                            </div>
                        @else
                            <span>{{ $reply->favorites_count }}</span>
                            <a href="{{ route('favorite.reply', [$reply->id]) }}" class="text-muted">
                                 <i class="fas fa-heart"></i>
                            </a>
                        @endif
                    </div>
                </div>
                <div class="card-body border-light text-secondary">
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
            <div class="card card-default border-light">
                <div class="card-body">
                    <span>
                        Posted {{ $thread->created_at->diffForHumans() }} by <a href="#"> {{ $thread->owner->name }}</a>.
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
