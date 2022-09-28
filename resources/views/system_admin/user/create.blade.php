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
        {{-- @if (Session::has('success'))
        <div class="alert alert-success alert-dismissible fade in">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">×</span></button>
            <strong>{{ Session::get('success') }}</strong>
        </div>
        @endif --}}

        <div class="create-user-parent-container">
            <h1>{{__('msg.Create User')}}</h1>
            <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data" class="create-user-container">

                @csrf
                {{-- <input type="text" value="{{$rfid}}" name="rfid"> --}}
                {{-- <div class="form-group">
                <!-- form-group -->
                </div> --}}

                <div class="create-user-inputs-parent-container">
                <div class="create-user-inputs-row">
                    <div class="create-user-name-container">
                    <label for="referee-name">{{__('msg.Name')}}</label>
                    <input type="text" id="name" name="name" placeholder="Enter Your Name" required/>
                    </div>
                    <div class="create-user-phno-container">
                    <label for="referee-phno">{{__('msg.Phone Number')}}</label>
                    <input type="phone" id="phone" name="phone" placeholder="Enter Your Phone Number" required/>
                    </div>
                </div>

                <div class="create-user-inputs-row">
                    <div class="create-user-type-container">
                    <label>{{__('msg.Type')}}</label>
                    <select id="create-user-type" name="request_type">
                        <option value="guest">Guest</option>
                        <option value="referee">{{__('msg.referee')}}</option>
                        <option value="operationstaff">{{__('msg.operationstaff')}}</option>
                        <option value="agent">{{__('msg.Agent')}}</option>
                    </select>
                    </div>

                    <div class="create-user-opid-container">
                        <label for="operationstaff_code">{{__('msg.operationstaff')}} {{__('msg.Code')}}</label>
                        <input type="text" id="operationstaff_code" name="operationstaff_code" placeholder="Enter OperationStaff ID"/>
                    </div>

                    <div class="create-user-rfid-container">
                        <label for="referee_code">{{__('msg.referee')}} {{__('msg.Code')}}</label>
                        <input type="text" id="referee_code" name="referee_code" placeholder="Enter Referee ID"/>
                    </div>

                </div>

                <div class="create-user-inputs-row">
                    <div class="create-user-pw-container">
                    <label for="password">{{__('msg.Password')}}</label>
                    <input type="password" id="password" name="password" placeholder="Enter Password"/>
                    </div>
                    <div class="create-user-confirmpw-container">
                    <label for="referee-confirmpw">{{__('msg.Confirm Password')}}</label>
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
                    <button type="submit">{{__('msg.Create')}}</button>
                    <button type="reset">{{__('msg.Cancel')}}</button>
                </div>

                </div>
                @if (Session::has('success'))
                <div id="hide">
                    <h4 class="main-cash-alert"> {{ Session::get('success') }} <span class="closeBtn">X</span> </h4>
                </div>
                @endif

            </form>
        </div>

          {{-- <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div> --}}
                    <!--guest list start-->
                    <div class="user-list-parent-container">
                        <h1>{{__('msg.User List')}}</h1>
                        <table class="user-list-container">
                            <thead>
                                <tr class="user-list-labels-container">
                                    <th>{{__('msg.ID')}}</th>
                                    <th>{{__('msg.Name')}}</th>
                                    <th>{{__('msg.Phone Number')}}</th>
                                    <th>{{__('msg.Promote')}}</th>
                                    <th></th>
                                    {{-- <h2>Action</h2> --}}

                                </tr>
                            </thead>

                            <tbody class="user-list-rows-container">
                                @foreach ($users as $user)
                                    <tr class="user-list-row">
                                        <td>{{$user->id}}</td>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->phone}}</td>
                                        <td>
                                            <a href="{{route('promoteos',$user->id)}}">
                                            {{__('msg.operationstaff')}}
                                            </a>
                                            {{-- <a href="{{route('promoterf',$user->id)}}">
                                                user
                                            </a> --}}
                                        </td>
                                        <td class="user-list-row-actions-container">
                                            <a href="{{route('guestprofile',$user->id)}}">
                                                <iconify-icon icon="ant-design:exclamation-circle-outlined" class="user-list-row-icon"></iconify-icon>
                                            </a>
                                            <a href="{{route('guest.destroy',$user->id)}}">
                                                <iconify-icon icon="akar-icons:trash-can" class="user-list-row-icon"></iconify-icon>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>

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
