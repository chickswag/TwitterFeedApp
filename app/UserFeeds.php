<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserFeeds extends Model
{
    protected $table = "user_feeds";
    protected $fillable = [
        'user_name', 'user_ids'
    ];
    public function getUser(){

        return $this->hasOne('App\User', 'id', 'user_id');
    }
}
