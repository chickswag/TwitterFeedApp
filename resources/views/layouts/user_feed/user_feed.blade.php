@extends('layouts.feedsdashboard')
@section('sidebar')
    @endsection
    @section('content')
    <div class="card">
        <div class="card-header">{{ $title }}</div>

    </div>

        @if(isset($userfeed) && count($userfeed) == 0)
            <div class="card-body bg-warning">
            <div class=" ">No Feeds in this timeline</div>
            </div>
        @else
            <div class="card-body">
                @foreach($userfeed as $feed)

                    <div class="row">
                        <div class="bg-primary ">{{ $feed->tweet }}</div>
                    </div>

                @endforeach
            </div>
        @endif

    <div class="card-footer">
        <div class="btn btn-danger">Back</div>
    </div>

    @endsection
