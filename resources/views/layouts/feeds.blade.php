@extends('layouts.feedsdashboard')
@section('sidebar')
    <nav id="sidebar">
        <div class="custom-menu">
            <button type="button" id="sidebarCollapse" class="btn btn-primary">
                <i class="fa fa-bars"></i>
                <span class="sr-only"></span>
            </button>
        </div>
        <div class=""><h1><a href="/" class="logo"><span class="fa fa-user text-center text-capitalize"></span>&nbsp;&nbsp;&nbsp;Users</a></h1></div>
        <div class="d-flex flex-column">
            @if(isset($users) && count($users) == 0)
                <div class="border-info flex-fill p-2"> You currently have no users</div>
            @else
                @foreach($users as $user)

                    <div class=" bg-light text-dark flex-fill p-2"><u><a href="{{URL::to('/user/'.$user->user_name)}}" class="">{{ $user->user_name }}</a></u>
                        <div class="border border-primary"></div><br/>

                                @if(!is_null($user->user_ids))
                                <label class="text-dark font-italic">follows</label>
                                    @foreach(explode('|',$user->user_ids) as $follows)
                                        @foreach($user->where('id', $follows)->pluck('user_name') as $user_name)
                                            <a href="{{URL::to('/user/'.$user_name)}}" class=" btn-info text-light p-2 m-2">{{$user_name}}</a>
                                        @endforeach
                                    @endforeach

                                 @endif
                        </div>
                         <hr/>

                @endforeach
            @endif

        </div>

    </nav>
    @endsection
    @section('content')
    <div class="card">
        <div class="card-header">{{ $title }}</div>

    </div>
        @if(isset($feeds) && count($feeds) == 0)
            <div class="card-body bg-warning">
            <div class=" ">No Feeds in this timeline</div>
            </div>
        @else
            <div class="card-body">
                @foreach($feeds as $feed)

                    <div class="row">
                        <div class="p-2 ">
                            <div class=" ">{{ $feed->created_at.' '.$feed->getUser->user_name . ' > '.Illuminate\Support\Str::limit($feed->tweet, 140, '...') }}</div>

                        </div>
                    </div>
                    <hr/>
                @endforeach
            </div>
        @endif

    @endsection
