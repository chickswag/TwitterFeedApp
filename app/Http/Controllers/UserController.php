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
     * @param $name
     * @return array|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|string
     * @throws \Throwable
     */
    public function show($name)
    {

        try {
            $user = User::where('name',$name)->first();
            if($user){
                $title = $name. ' feeds ';
                $userFeed =  UserFeeds::where('user_id',$user->id)->orderBy('created_at','asc')->get();
                if(count($userFeed) > 0){
                    return view('layouts.user_feed.user_feed',compact('userFeed','title'))->render();
                }
                else{
                    return view('layouts.user_feed.user_feed',compact('title'))->render();
                }
            }
            else{
                return redirect('/')
                    ->withErrors('User doesnt exists')
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
