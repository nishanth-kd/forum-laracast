@component('activities.show.activity') 
    @slot('heading')
        <i class="fas fa-heart text-muted"></i> {{ $profile->name }} favorited <a href="{{ $activity->subject->favorited->path() }}">a {{ $activity->subject->favorited->getFavoritedType() }}</a>
    @endslot
    @slot('body')
        {{ $activity->subject->favorited->body }}
    @endslot
@endcomponent