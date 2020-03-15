<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserFeeds extends Model
{
    public function getUser(){

        return $this->hasOne('App\User', 'id', 'user_id');
    }
}
