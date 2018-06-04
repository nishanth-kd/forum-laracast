@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Thread</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <h5 class="card-title">{{ $thread->title }}</h5>
                    
                    <p class="card-text">
                        <h7 class="card-subtitle mb-2 text-muted">
                                by <a href="#"> {{ $thread->owner->name }}</a> 
                        </h7><br><br>
                        {{ $thread->body }}
                    </p>
                </div>
            </div>
        </div>
    </div>
    <hr>
    
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Replies</div>
                <div class="card-body">
                    @foreach($thread->replies as $reply)
                        <h6 class="card-subtitle mb-2 text-muted" id ="reply-{{ $reply->id }}">
                            <a href="#">{{ $reply->owner->name }}</a> says <a href="#reply-{{ $reply->id }}">{{ $reply->created_at->diffForHumans() }}</a></h6>
                        {{ $reply->body }}
                        <br>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    
</div>
@endsection
