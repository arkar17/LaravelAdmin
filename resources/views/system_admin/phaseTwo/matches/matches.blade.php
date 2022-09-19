@extends('system_admin.layouts.app')

@section('content')
        @if (Session::has('success'))
        <div class="alert alert-success alert-dismissible fade in">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">×</span></button>
            <strong>{{ Session::get('success') }}</strong>
        </div>
        @endif

        <div class="create-user-parent-container">
            <h1>Create Matches</h1>
            <form action="{{ route('matches.store') }}" method="POST" enctype="multipart/form-data" class="create-user-container">
                @csrf
                <div class="create-referee-inputs-row">
                        <div class="create-referee-role-container">
                            <label>Team One</label>
                            <select  name="team_one_name">
                                @foreach ($match_register_teams as $match_register_team)
                                <option value="{{$match_register_team->id}}">{{$match_register_team->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="create-referee-role-container">
                            <label>Team Two</label>
                            <select  name="team_two_name">
                                @foreach ($match_register_teams as $match_register_team)
                                <option value="{{$match_register_team->id}}">{{$match_register_team->name}}</option>
                                @endforeach
                            </select>
                        </div>
                </div>

                <div class="create-referee-inputs-row">
                    <div class="create-referee-role-container">
                        <label>Tournament</label>
                        <select name="tournament_name">
                            @foreach ($match_register_tournaments as $match_register_tournament)
                            <option value="{{$match_register_tournament->id}}" >{{$match_register_tournament->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="create-referee-name-container">
                        <label for="referee-name">Match Type</label>
                        <input type="text" placeholder="Enter Time " name="match_type">

                    </div>
            </div>

            <div class="create-referee-inputs-row">
                <div class="create-referee-date-container">
                    <label for="date">Date:</label>
                    <input type="date" id="date" name="date">
                </div>
                <div class="create-referee-name-container">
                    <label for="referee-name">Time</label>
                    <input type="text" placeholder="Enter Time " name="time">

                </div>
            </div>
                {{-- <div class="create-user-inputs-parent-container">
                <div class="create-user-inputs-row">
                    <div class="create-user-name-container">
                    <label for="referee-name">Matches Name</label>
                    <input type="text" id="name" name="name" placeholder="Enter Tournament Name"/>
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
                    {{-- <div class="user-list-parent-container">
                        <h1>User List</h1>
                        <div class="user-list-container">
                        <div class="user-list-labels-container">
                            <h2>ID</h2>
                            <h2>Name</h2>
                            <h2>Phone Number</h2>
                            <h2>Promote</h2>
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

                    </div> --}}
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
@endsection
