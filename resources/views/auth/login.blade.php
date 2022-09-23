@extends('layouts.app_plain')
@section('content')
<div class="parent-container">

    <div class="login-form-parent-container">
        <form  action="{{ route('login') }}" class="login-form-container" method="POST">
            @csrf
        @if (Session::has('message'))
        <div class="alert alert-danger alert-dismissible fade in">
            <a href="#" class="close" data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">×</span></a>
            <strong>{{ Session::get('message') }}</strong>
        </div>
        @endif
        <div class="login-username-container">
          <p>Phone Number:</p>
          <input type="number" name="phone" required/>
        </div>
        <div class="login-pw-container">
          <p>Password:</p>
          <input type="password" name="password" required/>
        </div>

        <div class="login-form-btn-container">
          <button type="submit" >Log In</button>
          <button type="reset">Cancel</button>
        </div>


      </form>
    </div>
  </div>

@endsection

