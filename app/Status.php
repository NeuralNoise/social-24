<?php

namespace Chatty;

use Illuminate\Database\Eloquent;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'statuses';

    protected $fillable = [
        'body'
    ];

    /**
     * Relationship : A status belongs to a User
     */
    public function user()
    {
        return $this->belongsTo('Chatty\User', 'user_id');
    }

}