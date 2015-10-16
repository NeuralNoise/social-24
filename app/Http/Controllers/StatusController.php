<?php

namespace Chatty\Http\Controllers;

use Auth;
use Chatty\User;
use Chatty\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function postStatus(Request $request)
    {
        $this->validate($request, [
            'status' => 'required|max:1000',
        ]);

        Auth::user()->statuses()->create([
            'body' => $request->input('status'),
        ]);

        return redirect()->route('home')->with('info', 'Status posted.');

    }

    public function postReply(Request $request, $statusId)
    {
        $this->validate($request, [
            "reply-{$statusId}" => 'required|max:1000'
        ], [
            'required' => 'The reply body is required.'
        ]);

        $status = Status::notReply()->find($statusId);

        if ( !$status )
        {
            return redirect()->route('home');
        }

        // check that the currently authenticated user is friend with the user who status this is
        if ( !Auth::user()->isFriendWith($status->user) && Auth::user()->id !== $status->user_id)
        {
            return redirect()->route('home');
        }

        $reply = Status::create([
            'body' => $request->input("reply-{$statusId}"),
        ])->user()->associate(Auth::user());

        $status->replies()->save($reply);

        return redirect()->back();

    }

}