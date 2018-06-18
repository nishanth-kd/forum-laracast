@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

        </div>
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-8"><span>Forum Threads</span></div>
                        @if(auth()->check())
                        <div class="col-md-4 text-right"><a href="/threads/create" class="">+ Post Thread</a></div>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    @foreach($threads as $thread)
                    <a href="{{ $thread->path() }}">
                        <h4>{{ $thread->title }}</h4>
                    </a>
                    <p class="text-muted">{{ $thread->owner->name }} posted {{ $thread->created_at->diffForHumans() }} and has <strong>{{ $thread->replies_count }} {{ str_plural('reply', $thread->replies_count) }}</strong></p>
                    <p>{{ $thread->body }}</p>
                    <hr>
                    @endforeach
                </div>
            </div>
            <br>
            
        </div>
    </div>
</div>
@endsection
