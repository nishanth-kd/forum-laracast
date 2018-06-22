@extends('layouts.app')

@section('content')
<div class="container el">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            <div class="row">
                <div class="col-md-8">
                    <h1 class="display-4">Threads</h1>
                </div>
                @if(auth()->check())
                <div class="col-md-4 text-right"><a href="/threads/create" class="btn btn-primary" style="margin-top: 20px;"><i class="fas fa-plus"></i> Post Thread</a></div>
                @endif
            </div>
            @include('threads.listing', ['threads' => $threads])
        </div>
    </div>
</div>
@endsection
