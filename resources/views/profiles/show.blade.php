@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row  justify-content-center">
            <div class="col-md-8">
                <h1 class="display-4">{{ $profile->name }}</h1>
                <h4 class="text-muted">Since {{ $profile->created_at->diffForHumans() }}</h4>
                @include('threads.listing', ['threads' => $threads])
            </div>
        </div>
    </div>
@endsection