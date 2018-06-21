@component('activities.show.activity') 
    @slot('heading')
        {{ $profile->name }} posted <a href="{{ $activity->subject->path() }}">"{{ $activity->subject->title }}"</a>
        @endslot
    @slot('body')
        {{ $activity->subject->body }}
    @endslot
@endcomponent