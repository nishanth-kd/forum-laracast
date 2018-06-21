@component('activities.show.activity') 
    @slot('heading')
        {{ $profile->name }} replied to <a href="{{ $activity->subject->thread->path() }}#reply-{{ $activity->subject->id }}">"{{ $activity->subject->thread->title }}"</a>
    @endslot
    @slot('body')
        {{ $activity->subject->body }}
    @endslot
@endcomponent