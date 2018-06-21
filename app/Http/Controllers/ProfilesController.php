<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Activity;

class ProfilesController extends Controller
{
    public function show(User $user) {
        return view('profiles.show', [
            'profile' => $user,
            'dailyActivities' => Activity::feed($user)
        ]);
    }

    protected function getDailiyProfileActivities(User $user) {
        return $user->activities()->with('subject')->take(50)->get()->groupBy(function($activity){
            return $activity->created_at->format('Y-m-d');
        });
    }
}
