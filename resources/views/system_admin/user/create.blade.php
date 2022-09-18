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
            <h1>Create User</h1>
            <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data" class="create-user-container">

                @csrf
                {{-- <input type="text" value="{{$rfid}}" name="rfid"> --}}
                {{-- <div class="form-group">
                <!-- form-group -->
                </div> --}}

                <div class="create-user-inputs-parent-container">
                <div class="create-user-inputs-row">
                    <div class="create-user-name-container">
                    <label for="referee-name">Name</label>
                    <input type="text" id="name" name="name" placeholder="Enter Your Name"/>
                    </div>
                    <div class="create-user-phno-container">
                    <label for="referee-phno">Phone Number</label>
                    <input type="text" id="phone" name="phone" placeholder="Enter Your Phone Number"/>
                    </div>
                </div>

                <div class="create-user-inputs-row">
                    <div class="create-user-type-container">
                    <label>Type</label>
                    <select id="create-user-type" name="request_type">
                        <option value="guest">Guest</option>
                        <option value="referee">Referee</option>
                        <option value="operationstaff">OperationStaff</option>
                        <option value="agent">Agent</option>
                    </select>
                    </div>

                    <div class="create-user-opid-container">
                        <label for="operationstaff_code">Operationstaff_id</label>
                        <input type="text" id="operationstaff_code" name="operationstaff_code" placeholder="Enter OperationStaff ID"/>
                    </div>

                    <div class="create-user-rfid-container">
                        <label for="referee_code">Referee_id</label>
                        <input type="text" id="referee_code" name="referee_code" placeholder="Enter Referee ID"/>
                    </div>

                </div>

                <div class="create-user-inputs-row">
                    <div class="create-user-pw-container">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter Password"/>
                    </div>
                    <div class="create-user-confirmpw-container">
                    <label for="referee-confirmpw">Confirm Password</label>
                    <input type="password" id="referee-confirmpw" name="confirmpasword" placeholder="Re-enter Password"/>
                    </div>
                </div>

                {{-- <div class="create-user-inputs-row">
                    <div class="create-user-name-container">
                        <div class="create-user-pw-container">
                            <label for="referee-pw">Operation Staff ID</label>
                            <input list="opid" name="parent_id" placeholder="Enter Operation Staff ID" id="operationstaff_id">
                            <datalist id="opid" name="parent_id">
                                @foreach ($operation_staffs as $operation_staff)
                                <option>{{$operation_staff->operationstaff_id}}</option>
                                @endforeach
                            </datalist>
                        </div>
                    </div>
                </div> --}}

                <div class="create-user-inputs-btns-container">
                    <button type="submit">Create</button>
                    <button type="button">Cancel</button>
                </div>

                </div>

            </form>
        </div>

          {{-- <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div> --}}
                    <!--guest list start-->
                    <div class="user-list-parent-container">
                        <h1>User List</h1>
                        <div class="user-list-container">
                        <div class="user-list-labels-container">
                            <h2>ID</h2>
                            <h2>Name</h2>
                            <h2>Phone Number</h2>
                            <h2>Promote</h2>
                            {{-- <h2>Action</h2> --}}

                        </div>

                        <div class="user-list-rows-container">
                            @foreach ($users as $user)
                                <div class="user-list-row">
                                    <p>{{$user->id}}</p>
                                    <p>{{$user->name}}</p>
                                    <p>{{$user->phone}}</p>
                                    <div>
                                        <a href="{{route('promoteos',$user->id)}}">
                                            Operation Staff
                                        </a>
                                        {{-- <a href="{{route('promoterf',$user->id)}}">
                                            user
                                        </a> --}}
                                    </div>
                                    <div class="user-list-row-actions-container">
                                        <a href="{{route('guestprofile',$user->id)}}">
                                            <iconify-icon icon="ant-design:exclamation-circle-outlined" class="user-list-row-icon"></iconify-icon>
                                        </a>
                                        <a href="{{route('guest.destroy',$user->id)}}">
                                            <iconify-icon icon="akar-icons:trash-can" class="user-list-row-icon"></iconify-icon>
                                        </a>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                        </div>

                    </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                {{-- </div>
            </div>
        </div> --}}

@endsection
