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
                @include('threads.reply', ['reply' => $reply])
            @endforeach
            {{ $replies->links() }}
            <br>
            @if(auth()->check())
            <form action="{{ $thread->path() . '/replies' }}" method="post">
                {{ csrf_field() }}
                <div class="form-group">
                    <textarea name="body" id="post-reply-body" cols="2" class="form-control" placeholder="Say something..." rows="4"></textarea>
                </div> 
                <button type="submit" class="btn btn-primary"><i class="fas fa-comment "></i> Reply</button>
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
