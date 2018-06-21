@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row  justify-content-center">
            <div class="col-md-8">
                <h1 class="display-4">{{ $profile->name }}</h1>
                @include('activities.listing', ['dailyActivities' => $dailyActivities])
            </div>
        </div>
    </div>
@endsection