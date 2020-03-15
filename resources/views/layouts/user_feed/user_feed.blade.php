@extends('layouts.feedsdashboard')
@section('sidebar')
    @endsection
    @section('content')
    <div class="card">
        <div class="card-header">{{ $title }}</div>

    </div>

            @if(!isset($userFeed))
                <div class="card-body bg-warning">
                    <div class=" ">No Feeds in this timeline</div>
                </div>
                @else

                <div class="card-body">
                    @foreach($userFeed as $feed)

                        <div class="d-flex flex-column mb-3">

                            <div class="font-italic">{{$feed->getUser->user_name }}</div>
                            <div class="">{{Illuminate\Support\Str::limit($feed->tweet, 140, '...') }}</div>
                            <div class="">{{ $feed->created_at}}</div>
                        </div>

                    @endforeach
                </div>
            @endif

    <div class="card-footer">
        <div class="btn btn-danger"><a href="{{ URL::previous()}}">Back</a></div>
    </div>

    @endsection
