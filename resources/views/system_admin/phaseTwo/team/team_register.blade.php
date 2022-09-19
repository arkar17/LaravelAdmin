@extends('system_admin.layouts.app')

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
        @if (Session::has('success'))
        <div class="alert alert-success alert-dismissible fade in">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">×</span></button>
            <strong>{{ Session::get('success') }}</strong>
        </div>
        @endif

        <div class="create-user-parent-container">
            <h1>Create Team</h1>
            <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data" class="create-user-container">
                @csrf

                <div class="create-user-inputs-parent-container">
                <div class="create-user-inputs-row">
                    <div class="create-user-name-container">
                    <label for="referee-name">Team Name</label>
                    <input type="text" id="name" name="name" placeholder="Enter Team Name"/>
                    </div>
                </div>

                <div class="create-user-inputs-btns-container">
                    <button type="submit">Create</button>
                    <button type="button">Cancel</button>
                </div>

                </div>

            </form>
        </div>

@endsection
