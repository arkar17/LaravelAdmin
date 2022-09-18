@extends('layouts.app_plain')

@section('content')
<div class="container-fluid">
    <div class="login-wrapper row">
        <div id="login" class="login loginpage col-lg-offset-2 col-md-offset-3 col-sm-offset-3 col-xs-offset-0 col-xs-12 col-sm-6 col-lg-8">
            <div class="login-form-header">
                 <img src="../data/icons/signup.png" alt="login-icon" style="max-width:64px">
                 <div class="login-header">
                     <h4 class="bold color-white">Signup Now!</h4>
                     <h4><small>Please enter your data to register.</small></h4>
                 </div>
            </div>

            <div class="box login">

                <div class="content-body" style="padding-top:30px">

                    <form id="msg_validate" action="{{ route('register') }}" method="POST" novalidate="novalidate" class="no-mb no-mt">
                        @csrf
                        <div class="row">
                            <div class="col-xs-12">

                                <div class="col-lg-6 no-pl">
                                    <div class="form-group">
                                        <label class="form-label">User name</label>
                                        <div class="controls">
                                            <input type="text" class="form-control" name="name" placeholder="enter username">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 no-pr">
                                    <div class="form-group">
                                        <label class="form-label">Phone</label>
                                        <div class="controls">
                                            <input type="text" class="form-control" name="phone" placeholder="enter phone">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 no-pl">
                                    <div class="form-group">
                                        <label class="form-label">Password</label>
                                        <div class="controls">
                                            <input type="password" class="form-control" name="password" placeholder="enter password">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 no-pr">
                                    <div class="form-group">
                                        <label class="form-label">Repeat Password</label>
                                        <div class="controls">
                                            <input type="password_confirmation" class="form-control" name="password_confirmation" placeholder="repeat password">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="pull-right">
                            <button type="reset" class="btn btn-secondary">Cancel</button>
                            <button type="submit" class="btn btn-info">Login</button>
                        </div>
                    </form>
                </div>
            </div>

            <p id="nav">
                <a class="pull-left" href="#" title="Password Lost and Found">Forgot password?</a>
                <a class="pull-right" href="ui-login.html" title="Sign Up">Login</a>
            </p>

        </div>
    </div>
</div>
@endsection
