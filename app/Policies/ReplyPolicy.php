<?php

namespace App\Policies;

use App\User;
use App\Models\Reply;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReplyPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the reply.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Reply  $reply
     * @return mixed
     */
    public function view(User $user, Reply $reply)
    {
        return true;
    }

    /**
     * Determine whether the user can create replies.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return auth()->check();
    }

    /**
     * Determine whether the user can update the reply.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Reply  $reply
     * @return mixed
     */
    public function update(User $user, Reply $reply)
    {
        return auth()->check() && auth()->id() == $reply->user_id;
    }

    /**
     * Determine whether the user can delete the reply.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Reply  $reply
     * @return mixed
     */
    public function delete(User $user, Reply $reply)
    {
        return auth()->check() && auth()->id() == $reply->user_id;
    }
}
