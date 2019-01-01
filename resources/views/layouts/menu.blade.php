<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/dashboard/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/dashboard/css/style.css') }}">
    <script src="{{ asset('assets/dashboard/js/bootstrap.min.js') }}"></script>

    <style>
        header{
            background-color: #DBE0E7;
        }
    </style>
</head>
<body>
@yield('header')
<div class="container-fluid" style="padding-left: 0">
    <div class="row">
        <div class="col-md-2">
            <!-- It can be fixed with bootstrap affix http://getbootstrap.com/javascript/#affix-->
            <div id="sidebar" class="well sidebar-nav">
                <h5>
                    <small><b>MANAGEMENT</b></small>
                </h5>
                <ul class="nav nav-pills nav-stacked">
                    @can('is_admin')
                        <li><a href="{{ route('assignments.index') }}">Assignments</a></li>
                        <li><a href="{{ route('groups.index') }}">Groups</a></li>
                        <li><a href="{{ route('users.index') }}">Users</a></li>
                    @endcan
                    {{--<li><a href="#"></a></li>--}}
                </ul>
            </div>
        </div>
        <div class="col-md-10">
            @yield('content')
        </div>
    </div>
</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="{{ asset('assets/dashboard/js/bootstrap.min.js') }}"></script>

@stack('body_js')
@if (Auth::check())
    <script src="{{ asset('js/online_timer.js') }}"></script>
@endif
</body>
</html>
