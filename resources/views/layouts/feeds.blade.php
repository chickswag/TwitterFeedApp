<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Ticket Logging') }}</title>

    <!-- Scripts -->

    <script src="{{ asset('js/jquery.min.js')}}"></script>
    <script src="{{ asset('js/jquery-confirm.js')}}"></script>

    <script src="{{ asset('js/bootstrap.min.js') }}" defer></script>
    <script src="{{ asset('js/custom.js') }}" defer></script>

    <script src="{{ asset('js/jquery-ui.min.js') }}" defer></script>
    <script src="{{ asset('js/popper.js') }}" defer></script>
    <script src="{{ asset('js/main.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery-confirm/jquery-confirm.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

</head>
<body>

<div id="app">
    <div class="wrapper d-flex align-items-stretch">
        @if(Auth::check())
            <nav id="sidebar">
                <div class="custom-menu">
                    <button type="button" id="sidebarCollapse" class="btn btn-primary">
                        <i class="fa fa-bars"></i>
                        <span class="sr-only"></span>
                    </button>
                </div>
                <div class=""><h1><a href="/" class="logo"><span class="fa fa-eye"></span>&nbsp;&nbsp;&nbsp;Ticketing</a></h1></div>
                <ul class="list-unstyled components mb-5">
                    <li class="active">
                        <a href="#"><span class="fa fa-home mr-3"></span> Profile</a>
                    </li>
                    @if(Auth::user()->hasAnyRole(array('agent')))
                        <li>
                            <a href="/ticketlogs/create"><span class="fa fa-cogs mr-3"></span> Log A Ticket</a>
                        </li>
                    @endif
                    <li>
                        <a href="/ticketlogs"><span class="fa fa-cogs mr-3"></span> Ticket Logs</a>
                    </li>
                    @if(Auth::user()->hasAnyRole(array('root','manager','technician')))

                        <li>
                            <a href="/personsInterests"><span class="fa fa-question mr-3"></span> Complex Query</a>
                        </li>

                        <li>
                            <a href="/changelog"><span class="fa fa-sticky-note mr-3"></span>Change Log</a>
                        </li>

                        <li>
                            <a href="/file-manipulation"><span class="fa fa-file-archive-o mr-3"></span>  File Manipulation</a>
                        </li>
                    @endif

                    <li><a href="{{route('logout')}}">
                            <span class="fa fa-user mr-3"></span>  Logout
                        </a>
                    </li>

                </ul>

            </nav>
    @endif
    <!-- Page Content  -->
        <main id="content" class="p-4 p-md-5 pt-5">
            <div class="display-messages">


                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <span class="fa fa-times-circle fa-2x" ></span><strong> - Ooops !</strong> There were some problems with your input.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (\Session::has('success'))
                    <div class="alert alert-success"><span class="fa fa-check-circle fa-2x"></span><em style="vertical-align: text-bottom;"> {!! \Session::get('success'); !!}</em></div>

                @endif
                @if (\Session::has('warning'))
                    <div class="alert alert-warning"><span class="fa fa-info-circle fa-2x"></span><em style="vertical-align: text-bottom;"> {!! \Session::get('warning'); !!}</em></div>

                @endif
                @if (\Session::has('info'))
                    <div class="alert alert-info"><span class="fa fa-info-circle fa-2x"></span><em style="vertical-align: text-bottom;"> {!! \Session::get('info'); !!}</em></div>

                @endif

            </div>
            @yield('content')
        </main>

    </div>
</div>
</body>
</html>
