<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Reply;
use Illuminate\Http\Request;
use App\Models\Thread;

class FavoritesController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function favoriteReply(Reply $reply, Request $request)
    {
        $reply->favorite();
    }

    public function favoriteThread(Thread $thread, Request $request)
    {
        $thread->favorite();
    }

    public function unfavoriteReply(Reply $reply, Request $request) {
        $reply->unfavorite();
    }

    public function unfavoriteThread(Thread $thread, Request $request) {
        $thread->unfavorite();
    }

    public function show(Favorite $favorite)
    {
        //
    }


    public function edit(Favorite $favorite)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Favorite  $favorite
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Favorite $favorite)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Favorite  $favorite
     * @return \Illuminate\Http\Response
     */
    public function destroy(Favorite $favorite)
    {
        //
    }
}
