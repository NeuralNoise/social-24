<?php

namespace Chatty\Http\Controllers;

use Auth;
use Chatty\User;
use Illuminate\Http\Request;

class FriendController extends Controller
{

    public function getIndex()
    {
        $friends = Auth::user()->friends();

        $requests = Auth::user()->friendRequests();

        return view('friends.index')
            ->with('friends', $friends)
            ->with('requests', $requests);
    }

    /**
     * Send a friend request
     */
    public function getAdd($username)
    {
        $user = User::where('username', $username)->first();
        //if the user can be found
        if (!$user)
        {
            return redirect()->route('home')->with('info', 'The user couldn\'t be found');
        }
        //check if we send the request back to us
        if ( Auth::user()->id === $user->id )
        {
            return redirect()->route('home');
        }
        //if the request is being already set
        if ( Auth::user()->hasFriendRequestPending($user) || $user->hasFriendRequestPending(Auth::user()) )
        {
            return redirect()->route('profile.index', ['username' => $user->username])
                ->with('info', 'Friend request already pending.');
        }
        //if we are already friends
        if ( Auth::user()->isFriendWith($user) )
        {
            return redirect()->route('profile.index', ['username' => $user->username])
                ->with('info', 'You are already friends.');
        }

        Auth::user()->addFriend($user);

        return redirect()
            ->route('profile.index', ['username' => $user->username])
                ->with('info', 'Friend request sent.');

    }

    /**
     * Accept a friend request
     */
    public function getAccept($username)
    {
        $user = User::where('username', $username)->first();

        //if the user can be found
        if (!$user)
        {
            return redirect()->route('home')->with('info', 'The user couldn\'t be found');
        }

        //if we actually received a friend request from this user
        if ( !Auth::user()->hasFriendRequestReceived($user) )
        {
            return redirect()->route('home');
        }

        Auth::user()->acceptFriendRequest($user);

        return redirect()->route('profile.index', ['username' => $username])
            ->with('info', 'Friend Request accepted');

    }

}