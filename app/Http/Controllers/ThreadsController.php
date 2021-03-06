<?php

namespace App\Http\Controllers;

use App\Filters\ThreadFilters;
use App\Models\Thread;
use App\Models\Channel;
use App\User;
use Illuminate\Http\Request;

class ThreadsController extends Controller
{
    public function __construct() {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }
   
    public function index(Channel $channel, ThreadFilters $filters)
    {
        $threads = Thread::filter($filters);
        if ($channel->exists) {
            $threads = $threads->where('channel_id', $channel->id);
        }
        $threads = $threads->latest();
        if(request()->wantsJson()) {
            return $threads->get();
        } else {
            return view('threads.index', [
                'threads' => $threads->paginate(10)
            ]);
        }
    }


    public function create()
    {
        return view('threads.create', compact('channels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
            'channel_id' => 'required|exists:channels,id'
        ]);

        $thread = Thread::create([
            'title' => $request->input('title'),
            'body' => $request->input('body'),
            'channel_id' => $request->input('channel_id'),
            'user_id' => auth()->id(),
        ]);
        return redirect($thread->path())
            ->with('flash', "Your thread has been published");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function show($channelSlug, Thread $thread)
    {
        return view('threads.show', [
            'thread' => $thread
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function edit(Channel $channel, Thread $thread)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Thread $thread)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function destroy($channelSlug, Thread $thread)
    {
        $this->authorize('delete', $thread);
        $thread->delete();
        return redirect('/threads');
    }
}
