<?php


namespace Chatty;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $table = 'likeable';

    /**
     * This is a polymorphic relationship, this can be applied to any model
     */
    public function likeable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo('Chatty\User', 'user_id');
    }

}