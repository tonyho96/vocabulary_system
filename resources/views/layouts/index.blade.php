<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    @stack('css')
</head>
<style>
    body{
        background: #E7EDEE;
    }

    h1{
        font-size:50px;
    }

    h2 {
        font-size:30px;
    }

    h3 {
        font-size:18px;
    }

    .container{
        background: #EFF5F6;
        margin-top: 30%;
        max-width: 500px;
        border-radius: 50%;
        position: static;
        padding: 0%;
        border: solid 2px #CBD5DA;
    }

    .row{
        top: 12%;
        position: relative;
        width: 100%;
    }

    .line{
        width:100%;
        height: 100%;
    }

    .list-menu{
        position: static;
        text-align: center;
        min-height: 80px;
        margin-top: 20px;
    }

    .button button{
        padding: 15px 5px;
    }

    #index{
        margin-top: 30px;
    }
</style>

<style>
    html, body {
        /*background-color: #fff;*/
        color: #636b6f;
        font-family: 'Raleway', sans-serif;
        font-weight: 100;
        height: 100vh;
        margin: 0;
    }

    .full-height {
        height: 100vh;
    }

    .flex-center {
        align-items: center;
        display: flex;
        justify-content: center;
    }

    .position-ref {
        position: static;
    }

    .top-center {
        position: absolute;
        top: 2px;
    }

    .top-right {
        position: absolute;
        right: 90px;
        top: 18px;
    }

    .content {
        text-align: center;
    }

    .title {
        font-size: 84px;
    }

    .links > a {
        color: #636b6f;
        padding: 0 25px;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: .1rem;
        text-decoration: none;
        text-transform: uppercase;
    }

    .m-b-md {
        margin-bottom: 30px;
    }

    .countNum {
        color: #2579A9;
        font-size: 18px;
        font-weight: bold;
        text-align: center;
        width: 30%;
    }

    .main {
        font-size: 14px;
    }
</style>
<body>
<div class="text-center">
    @if (Session::has('error'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            {{Session::get('error')}}
        </div>
    @endif
    @if (Session::has('message'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            <p><i class="icon fa fa-check"></i>{{Session::get('message')}}</p>
        </div>
    @endif
</div>
<div class="flex-center position-ref full-height">
    @if (Route::has('login'))
        @section('top-center')
            <div class="top-center">
                @if(!(Auth::user()->role == config('user.role.student')) && !(Auth::user()->role == config('user.role.parent')))
                    <h1 align="center" style="margin-top: 90px;">{{ Auth::user()->name }}</h1>
                @else
                    <h1 align="center">{{ Auth::user()->name }}</h1>
                    <h2 align="center">Total Points</h2>
                    <input style="margin-left: 26px; width: 150px; text-align: center; border: none; font-size: 25px; font-weight: bold; color: red;" type="text" readonly="" value="{{ @$totalGlobalLetter }}">
                @endif
            </div>
        @show
        <div class="top-right links">
            @auth
                @if(Auth::user()->isAdmin())
                    <a href="{{ route('assignments.index') }}">Assignments</a>
                        <span>
                            <input class="countNum" style="width: 40px;" type="text" readonly value="{{ count(@$assignments) }}">
                        </span>
                    <a href="{{ route('groups.index') }}">Groups
                        <span>
                            <input class="countNum" style="width: 40px;" type="text" readonly value="{{ count(@$group) }}">
                        </span>
                    </a>
                    <a href="{{ route('users.index') }}">Users
                        <span>
                            <input class="countNum" style="width: 40px;" type="text" readonly value="{{ count(@$student) }}">
                        </span>
                    </a>
                @endif
                @if(Auth::user()->isTeacher())
                    <a href="{{ route('assignments.index') }}">Assignments</a>
                        <span>
                            <input class="countNum" style="width: 40px;" type="text" readonly value="{{ count(@$assignments) }}">
                        </span>
                    <a href="{{ route('groups.index') }}">Groups
                        <span>
                            <input class="countNum" style="width: 40px;" type="text" readonly value="{{ count(@$group) }}">
                        </span>
                    </a>
                    <a href="{{ route('users.index') }}">Users
                        <span>
                            <input class="countNum" style="width: 40px;" type="text" readonly value="{{ count(@$student) }}">
                        </span>
                    </a>
                @endif				
                <a href="{{ route('logout') }}"><button type="button" class="btn btn-primary ">Logout</button></a>
            @endauth
        </div>
    @endif
    @section('content')
        <div id="index">
            @if(Auth::user()->role == config('user.role.admin') || Auth::user()->role == config('user.role.teacher'))
            <div class="container" style="height: 500px;">
                {{--<svg class="line" height="100%" width="100%"   >--}}
                    {{--<line x1="50%" y1="0" x2="50%" y2="100%" style="stroke:#CBD5DA;stroke-width:2" />--}}
                    {{--<line x1="0" y1="50%" x2="100%" y2="50%" style="stroke:#CBD5DA;stroke-width:2" />--}}

                {{--</svg>--}}
                <div class="row" style="left: 15px;">
                    <div class="col-xs-6 list-menu">
                        <div class="class">
                            <a href="listings/sessions"><button type="button" class="main btn btn-primary" style="margin: 2px 0px 5px 0px; padding: 10px 5px; width: 80px;">Sessions</button></a>
                        </div>
                        <input class="countNum" type="text" readonly value="{{ count(@$sessions) }}">
                    </div>

                    <div class="col-xs-6 list-menu">
                        <div class="class">
                            <a href="listings/essays"><button type="button" class="main btn btn-primary" style="margin: 2px 0px 5px 0px; padding: 10px 5px; width: 80px;">Essays</button></a>
                        </div>
                        <input class="countNum" type="text" readonly value="{{ count(@$essays) }}">
                    </div>

                    <div class="col-xs-12 list-menu" style="position: static; margin-top: 10px;">
                        <a href="dashboard"><button type="button" class="btn btn-primary btn-lg" style="margin: 15px 0; padding: 10px 10px">New</button></a><br>
                        <a href="assignments"><button type="button" class="btn btn-primary btn-lg" style="margin: 15px 0; padding: 10px 10px;">Assignments</button></a>
                    </div>

                    <br>

                    <div class="col-xs-6 list-menu">
                        <div class="class">
                            <a href="listings/words"><button type="button" class="main btn btn-primary" style="margin: 2px 0px 5px 0px; padding: 10px 5px; width: 80px;">Vocabulary</button></a>
                        </div>
                        <input class="countNum" type="text" readonly value="{{ count(@$words) }}">
                    </div>

                    <div class="col-xs-6 list-menu">
                        <div class="class">
                            <a href="listings/sentences"><button type="button" class="main btn btn-primary" style="margin: 2px 0px 5px 0px; padding: 10px 5px; width: 80px;">Sentences</button></a>
                        </div>
                        <input class="countNum" type="text" readonly value="{{ count(@$sentences) }}">
                    </div>
                </div>
            </div>
            @else
            <div class="container" style="height: 400px;">
                <div class="row" style="left: 20px;">
                    <div class="col-xs-6 list-menu">
                        <div class="class">
                            <a href="listings/sessions"><button type="button" class="main btn btn-primary btn-lg" style="margin: 2px 0px 5px 0px; padding: 10px 10px">Sessions</button></a>
                        </div>
                        <input class="countNum" type="text" readonly value="{{ count(@$sessions) }}">
                    </div>

                    <div class="col-xs-6 list-menu">
                        <div class="class">
                            <a href="listings/essays"><button type="button" class="main btn btn-primary btn-lg" style="margin: 2px 0px 5px 0px; padding: 10px 10px">Essays</button></a>
                        </div>
                        <input class="countNum" type="text" readonly value="{{ count(@$essays) }}">
                    </div>

                    @if (Auth::user()->role == config('user.role.student'))
                        <div class="col-xs-12 list-menu" style="position: static; min-height: 40px; margin-top: 20px;">
                            <a href="user-assign"><button type="button" class="btn btn-primary btn-lg" style="margin: 15px 0; padding: 10px 10px;">Assignments</button></a>
                        </div>
                    @else
                        <div class="col-xs-12 list-menu" style="position: static; min-height: 40px; margin-top: 20px;"></div>
                    @endif

                    <br>
                    <div class="col-xs-6 list-menu">
                        <div class="class">
                            <a href="listings/words"><button type="button" class="main btn btn-primary btn-lg" style="margin: 2px 0px 5px 0px; padding: 10px 10px">Vocabulary</button></a>
                        </div>
                        <input class="countNum" type="text" readonly value="{{ count(@$words) }}">
                    </div>

                    <div class="col-xs-6 list-menu">
                        <div class="class">
                            <a href="listings/sentences"><button type="button" class="main btn btn-primary btn-lg" style="margin: 2px 0px 5px 0px; padding: 10px 10px">Sentences</button></a>
                        </div>
                        <input class="countNum" type="text" readonly value="{{ count(@$sentences) }}">
                    </div>
                </div>
            </div>
            @endif
        </div>
    @show
</div>
</body>
</html>
