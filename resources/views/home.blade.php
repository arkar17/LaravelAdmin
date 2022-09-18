@extends('layouts.app')

@section('content')
<script src="https://js.pusher.com/4.1/pusher.min.js"></script>
<script>

 var pusher = new Pusher('{{env("MIX_PUSHER_APP_KEY")}}', {
    cluster: '{{env("PUSHER_APP_CLUSTER")}}',
    encrypted: true
  });

  var channel = pusher.subscribe('notify-channel');
  channel.bind('App\\Events\\Notify', function(data) {
     alert(data.message);
  });
</script>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif


                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>

@endsection
