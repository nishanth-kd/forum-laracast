@forelse($dailyActivities as $date => $activities)
    <p class="text-secondary"><strong>{{ $date }}</strong></p>
    <hr>
    @foreach($activities as $activity)
        @if(view()->exists("activities.show.{$activity->type}"))
            @include("activities.show.{$activity->type}")
        @endif
    @endforeach
@empty
<div class="card card-default">
    <div class="card-body">
    <span>No activity yet.</span>
    </div>
</div>
@endforelse
