<?php

namespace App\Http\Controllers;

use App\User;
use App\UserFeeds;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @return array|string
     * @throws \Throwable
     */
    public function index()
    {
        $title = 'Tweets Dashboard';
        $users = User::get();
        $feeds = UserFeeds::orderBy('created_at','asc')->get();

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
     * @param $user_name
     * @return array|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|string
     * @throws \Throwable
     */
    public function show($user_name)
    {

        try {
            $user = User::where('user_name',$user_name)->first();
            if($user){
                $title = $user_name. ' tweets ';
                $userFollowersTweets =  User::where('id',$user->id)->pluck('user_ids');

                $arrIds =  [];
                foreach ( $userFollowersTweets as  $tweets){
                    foreach (explode('|',$tweets) as $userFollowIds){
                        array_push($arrIds, (int)$userFollowIds);
                    }
                }
                array_push($arrIds,$user->id);
                $userFeed =  UserFeeds::whereIn('user_id',$arrIds)->orderBy('created_at','asc')->get();
                if(count($userFeed) > 0){
                    return view('layouts.user_feed.user_feed',compact('userFeed','title'))->render();
                }
                else{
                    return view('layouts.user_feed.user_feed',compact('title'))->render();
                }
            }
            else{
                return redirect('/')
                    ->withErrors('User doesn\'t exists')
                    ->withInput();
            }
        }
        catch (\Exception $e) {

            return $e->getMessage();
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
