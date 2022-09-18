@extends('layouts.app_plain')

@section('content')
<div class="container-fluid">
    <div class="login-wrapper row">
        <div id="login" class="login loginpage col-lg-offset-4 col-md-offset-3 col-sm-offset-3 col-xs-offset-0 col-xs-12 col-sm-6 col-lg-4">
            <div class="login-form-header">
                 <img src="{{ asset('data/icons/padlock.png') }}" alt="login-icon" style="max-width:64px">
                 <div class="login-header">
                     <h4 class="bold color-white">Login Now!</h4>
                     <h4><small>Please enter your credentials to login.</small></h4>
                 </div>
            </div>
            <div class="box login">
                <div class="content-body" style="padding-top:30px">
                    <h3>Referee Login</h3>
                    <form  action="{{ route('login') }}" class="no-mb no-mt" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-xs-12">

                                <div class="form-group">
                                    <label for="phone" class="form-label">Phone Number</label>

                                        <input type="text" class="form-control" name="phone" placeholder="phone" autofocus>

                                </div>

                                <div class="form-group">
                                    <label for="password" class="form-label">Password</label>
                                    <div class="controls">
                                        <input type="text" class="form-control" name="password" placeholder="password" id="password">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="pull-right">
                            <button type="submit" class="btn btn-info">Login</button>
                            <button type="reset" class="btn btn-light">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>

            <p id="nav">
                <a class="pull-left" href="#" title="Password Lost and Found">Forgot password?</a>
                <a class="pull-right" href="{{ route('register') }}" title="Sign Up">Sign Up</a>
            </p>

        </div>
    </div>
</div>

@endsection
