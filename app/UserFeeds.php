<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserFeeds extends Model
{
    protected $table = "user_feeds";
    protected $fillable = [
         'user_id','tweet','created_at'
    ];
    public function getUser(){

        return $this->hasOne('App\User', 'id', 'user_id');
    }
}
