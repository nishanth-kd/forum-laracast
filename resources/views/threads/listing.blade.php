@forelse($threads as $thread)
<div class="card card-default border-light">
    <div class="card-header border-light">
        <div class="row">
            <div class="col-md-8">
                <a href="{{ $thread->path() }}">
                    <h4>{{ $thread->title }}</h4>
                </a>
                <span class="text-muted"><a href="{{ $thread->owner->profile() }}">{{ $thread->owner->name }}</a> posted {{ $thread->created_at->diffForHumans() }}</strong></span>
            </div>
            @if(auth()->check())
            <div class="col-md-4 text-right">
                @if($thread->isFavorited())
                    <div class="text-danger d-inline">
                        <span>{{ $thread->favorites_count }}</span> <i class="fas fa-heart"></i>
                    </div>
                @else
                <div class="text-muted d-inline">
                    <span>{{ $thread->favorites_count }}</span>
                    <a href="{{ route('favorite.thread', [$thread->id]) }}" >
                        <i class="fas fa-heart text-muted"></i>
                    </a>
                </div>
                @endif
                <div class="{{ ($thread->replies_count > 0) ? 'text-dark' : 'text-muted' }} d-inline">
                    <span>{{ $thread->replies_count }}</span> <i class="fas fa-comments"></i>
                </div>
            </div>
            @endif
        </div>
    </div>
    <div class="card-body border-light">
        <span>{{ $thread->body }}</span>
    </div>
</div>
<br>
@empty
<div class="card card-default">
    <div class="card-body">
    <span>No posts yet.</span>
    </div>
</div>
@endforelse
{{ $threads->links() }}
