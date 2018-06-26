<reply :attributes="{{ $reply }}" inline-template v-cloak>
    <div class="card card-default border-light" style="margin-bottom:10px">
        <div class="card-header border-light text-secondary d-flex justify-content-between" id ="reply-{{ $reply->id }}">
            <div class="align-middle">
                <a href="{{ $reply->owner->profile() }}" style="padding: 6px 0;" class="align-middle">{{ $reply->owner->name }}</a> said <a href="#reply-{{ $reply->id }}">{{ $reply->created_at->diffForHumans() }}</a>
            </div>
            <div>
                <favorite :model="{{ $reply }}"></favorite>
                @can('update', $reply)
                &nbsp;
                <div class="text-muted d-inline" data-toggle="tooltip" data-placement="top" title="Edit">
                    <a @click="editing = true" class="bg-light text-muted"><i class="fas fa-edit"></i></a>
                </div>
                @endcan
                @can('delete', $reply)
                &nbsp;
                <div class="text-muted d-inline" data-toggle="tooltip" data-placement="top" title="Delete">
                    <a href="#" @click="destroy" class="bg-light text-muted"><i class="fas fa-times"></i></a>
                </div>
                @endcan
            </div>
        </div>
        <div class="card-body border-light text-secondary">
            <div v-if="editing">
                <div class="form-group">
                    <textarea name="body" id="body-update-reply-{{ $reply->id }}" cols="2" v-model="body" class="form-control"></textarea>
                </div>
                <button @click="update" class="btn btn-primary btn-sm">Update</button>
                <button @click="editing = false" class="btn btn-light btn-sm text-danger">Cancel</button>
            </div>
            <div v-else v-text="body"></div>
        </div>
    </div>
</reply>