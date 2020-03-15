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
    @yield('sidebar')

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
