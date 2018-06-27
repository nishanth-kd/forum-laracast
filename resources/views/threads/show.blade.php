@extends('layouts.app')

@section('content')
<thread-view :initial-replies-count="{{ $thread->replies_count }}" inline-template>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card card-default border-light">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h3 class="display-4"> {{ $thread->title }} </h3>
                        </div>
                        {{ $thread->body }}
                        <hr>
                        <div class="action">
                            @can('update', $thread)
                            <a href="{{ $thread->path() }}/edit" class="btn btn-warning"><i class="fas fa-edit"></i> Edit Thread</a>
                            @endcan
                            @can('delete', $thread)
                            <form action="{{ $thread->path() }}" class="d-inline " method="POST">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i> Delete Thread</button>
                            </form>
                            @endcan
                        </div>
                    </div>
                </div>
                <hr>
                <h4 class="text-muted"><i class="fas fa-comments"></i> Replies</h4>
                <replies :data="{{ $thread->replies }}" @removed="removedReply" @added="addedReply" :endpoint="'{{  $thread->path() . '/replies' }}'"></replies>
            </div>
            <div class="col-md-4">
                <div class="card card-default border-light">
                    <div class="card-body">
                        <span>
                            Posted {{ $thread->created_at->diffForHumans() }} by <a href="#"> {{ $thread->owner->name }}</a> and has <span v-text="repliesCount"></span> replies.
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</thread-view>
@endsection
