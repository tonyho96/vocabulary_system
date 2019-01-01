@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading emphasize-text">Log in</div>

                    <div class="panel-body">
                        <form class="form-horizontal space" method="POST" action="{{ route('login') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                                <label for="username" class="col-sm-3 col-sm-offset-2 control-label">Username</label>

                                <div class="col-sm-4">
                                    <input id="username" type="text" class="form-control" name="username"
                                           value="{{ old('username') }}" required autofocus>

                                    @if ($errors->has('username'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                    @endif
                                    @if ($errors->has('role'))
                                        <span class="help-block" style="color: red">
                                        <strong>{{ $errors->first('role') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-sm-3 col-sm-offset-2 control-label">Password</label>

                                <div class="col-sm-4">
                                    <input id="password" type="password" class="form-control" name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-6 col-sm-offset-3">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox"
                                                   name="remember" {{ old('remember') ? 'checked' : '' }}> Remember
                                            username
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-8 col-sm-offset-2">
                                    <button type="submit" class="btn btn-primary emphasize-text">
                                        Log in
                                    </button>

                                    <p>
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            Forgotten your username or password?
                                        </a>
                                    </p>

                                    <p>Cookies must be enable in your browser
                                        <a href="#">
                                            <img src="https://png.icons8.com/small/20/cccccc/help.png">
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading emphasize-text">Is this your first time here?</div>

                    <div class="panel-body">
                        <p class="col-sm-8 col-sm-offset-2 space intro">For full access to this site, you first need to
                            create an account.</p>
                        <a href="{{ route('register') }}" class="btn btn-primary emphasize-text" id="register">Create
                            new account</a>
                        <div id="google-login">
                            <p>Log in using your account on: </p>
                            <a href="#" class="btn btn-default">
                                <img src="https://png.icons8.com/color/25/cccccc/google-logo.png">
                                <span>Google</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
