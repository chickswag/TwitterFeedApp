<?php

namespace App\Http\Controllers;

use App\User;
use App\UserFeeds;
use Illuminate\Http\Request;
use Input;
use Validator;
use Redirect;
class UserController extends Controller
{
    /**
     * @return array|string
     * @throws \Throwable
     */
    public function index()
    {
        $title = 'Feeds Dashboard';
        $users = User::get();
        $feeds = UserFeeds::orderBy('created_at','desc')->get();

        return view('layouts.feeds',compact('users','title','feeds'))->render();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($name)
    {

        $user = User::where('name',$name)->first();
        if($user){
            $title = $name. ' feeds ';
            $feed =  UserFeeds::find($user->id);
            $userfeed = '';
            if($feed){
                $users = User::get();
                $userfeed = UserFeeds::orderBy('created_at','desc')->get();

            }
            return view('layouts.user_feed.user_feed',compact('userfeed','title'))->render();


        }
        else{
            return response()->back()->withErrors('No user');
        }


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
