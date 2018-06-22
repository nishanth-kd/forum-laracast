@component('activities.show.activity') 
    @slot('heading')
        <i class="fas fa-comment text-muted"></i> {{ $profile->name }} replied to <a href="{{ $activity->subject->path() }}">"{{ $activity->subject->thread->title }}"</a>
    @endslot
    @slot('body')
        {{ $activity->subject->body }}
    @endslot
@endcomponent