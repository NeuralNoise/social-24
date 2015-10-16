<?php

namespace Chatty;

use Chatty\Status;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;


class User extends Model implements AuthenticatableContract

{
    use Authenticatable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['username', 'email', 'password', 'first_name', 'last_name', 'location'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function getName()
    {
        if ($this->first_name && $this->last_name)
        {
            return "{$this->first_name} {$this->last_name}";
        }
        if ($this->first_name)
        {
            return $this->first_name;
        }
        return null;
    }
    public function getNameOrUsername()
    {
        return $this->getName()?:$this->username;
    }

    public function getFirstNameOrUsername()
    {
        return $this->first_name?: $this->username;
    }

    public function getAvatarUrl()
    {
        return "https://www.gravatar.com/avatar/{{ md5($this->email) }}?d=mm&s=40";
    }


    /**
     * The friends of a user
     *
     * @    the model
     * @    the pivot table
     * @    matching by user_id
     * @    foreign key friend_id
     */

    public function friendsOfMine()
    {
        return $this->belongsToMany('Chatty\User', 'friends', 'user_id', 'friend_id');
    }


    /**
     * Users who have this user as a friend
     *
     * @    the model
     * @    the pivot table
     * @    matching by friend_id
     * @    foreign key user_id
     */

    public function friendOf()
    {
        return $this->belongsToMany('Chatty\User', 'friends', 'friend_id', 'user_id');
    }


    /**
     * Pulling back friends who have accepted the request
     */
    public function friends()
    {
        return $this->friendsOfMine()->wherePivot('accepted', true)->get()
            ->merge($this->friendOf()->wherePivot('accepted', true)->get());
    }

    public function friendRequests()
    {
        return $this->friendsOfMine()->wherePivot('accepted', false)->get();
    }


    /**
     * Pending friend request
     */
    public function friendRequestsPending()
    {
        return $this->friendOf()->wherePivot('accepted', false)->get();
    }

    /**
     * Check if a user has a friend request pending from another user
     */
    public function hasFriendRequestPending(User $user)
    {
        return (bool) $this->friendRequestsPending()->where('id', $user->id)->count();
    }

    /**
     * Check if we have received a friend request from a particular user
     */
    public function hasFriendRequestReceived(User $user)
    {
        return (bool) $this->friendRequests()->where('id', $user->id)->count();
    }

    /**
     * Add a friend
     */
    public function addFriend(User $user)
    {
        $this->friendOf()->attach($user->id);
    }

    /**
     * Accept a friend request
     */
    public function acceptFriendRequest(User $user)
    {
        $this->friendRequests()->where('id', $user->id)->first()
            ->pivot->update([
                'accepted' =>true,
            ]);
    }

    /**
     * Tell us if we are friends with a particular user
     */
    public function isFriendWith(User $user)
    {
        return (bool) $this->friends()->where('id', $user->id)->count();
    }

    /**
     * Relationship : A user can have many statuses
     */
    public function statuses()
    {
        return $this->hasMany('Chatty\Status', 'user_id');
    }

    public function hasLikedStatus(Status $status)
    {
        return (bool) $status->likes
            ->where('likeable_id', $status->id)
            ->where('likeable_type', get_class($status))
            ->where('user_id', $this->id)
            ->count();
    }

    public function likes()
    {
        return $this->hasMany('Chatty\Like', 'user_id');
    }
}
