@extends('system_admin.layouts.app')

@section('title', 'Dota Matches')

@section('styles')
    <style>
        .dota-match-container {
            display: flex;
            justify-content: center;
            gap: 50px;
            flex-wrap: wrap;
            padding: 20px;
        }

        .dota-match-card {
            width: 40%;
            border: 1px solid rgb(219, 205, 205);
            border-radius: 5px;
        }

        .dota-match-card-header {
            background-color: black;
            color: #eed;
            display: flex;
            justify-content: space-between;
            padding: 20px;
        }

        .dota-match-bell {
            color: #eed;

            margin-right: 10px;
        }

        .dota-match-card-body {
            padding: 20px;
            text-align: center;
        }

        .vs-teams {
            display: flex;
            justify-content: space-around;

        }

        .vs-teams span {
            display: flex;
            gap: 10px;
        }

        .dota-team-name {
            display: flex;
            align-items: center;
        }

        .dota-team-profile {
            width: 30px;
            height: 30px;
            padding: 1px;
            border: 1px solid #ddd;
            border-radius: 50%;
            align-self: center;
            background: #eee;
        }

        .dota-match-data {
            color: #555;
            font-size: 14px;
            margin-top: 20px;
        }

        .win-result{
            margin-top: 20px;
            display: flex;
            justify-content: center;
            gap: 10px;
        }
        .win-data{
            background-color: #ddd;
            padding: 5px;
            font-size: 12px;
            border-radius: 5px;

        }

    </style>
@endsection

@section('content')
    <div class="dota-match-container">
        <div class="dota-match-card">
            <div class="dota-match-card-header">
                <span> <i class="fa-solid fa-gamepad"></i> <span>Game 1</span> </span>
                <span><i class="fa-regular fa-bell dota-match-bell"></i> <i class="fa-regular fa-star"></i></span>
            </div>
            <div class="dota-match-card-body">
                <div class="vs-teams">
                    <span> <span class="dota-team-name">Team A</span> <img src="{{ asset('image/631dfb2793c4b_p1.png') }}" alt=""
                            class="dota-team-profile"> </span>
                    <span>VS</span>
                    <span><span class="dota-team-name">Team B</span><img src="{{ asset('image/631dfb2793c4b_p1.png') }}" alt=""
                            class="dota-team-profile"></span>
                </div>
                <div class="dota-match-data">
                    <p>13.9.2022</p>
                    <p>02:30PM</p>

                   <div class="win-result">
                    <span class="win-data">W1: 1.2</span>
                    <span class="win-data">W2: 13</span>
                   </div>
                </div>
            </div>
        </div>
        <div class="dota-match-card">
            <div class="dota-match-card-header">
                <span> <i class="fa-solid fa-gamepad"></i> <span>Game 1</span> </span>
                <span><i class="fa-regular fa-bell dota-match-bell"></i> <i class="fa-regular fa-star"></i></span>
            </div>
            <div class="dota-match-card-body">
                <div class="vs-teams">
                    <span> <span class="dota-team-name">Team A</span> <img src="{{ asset('image/631dfb2793c4b_p1.png') }}" alt=""
                            class="dota-team-profile"> </span>
                    <span>VS</span>
                    <span><span class="dota-team-name">Team B</span><img src="{{ asset('image/631dfb2793c4b_p1.png') }}" alt=""
                            class="dota-team-profile"></span>
                </div>
                <div class="dota-match-data">
                    <p>13.9.2022</p>
                    <p>02:30PM</p>

                   <div class="win-result">
                    <span class="win-data">W1: 1.2</span>
                    <span class="win-data">W2: 13</span>
                   </div>
                </div>
            </div>
        </div>

        <div class="dota-match-card">
            <div class="dota-match-card-header">
                <span> <i class="fa-solid fa-gamepad"></i> <span>Game 1</span> </span>
                <span><i class="fa-regular fa-bell dota-match-bell"></i> <i class="fa-regular fa-star"></i></span>
            </div>
            <div class="dota-match-card-body">
                <div class="vs-teams">
                    <span> <span class="dota-team-name">Team A</span> <img src="{{ asset('image/631dfb2793c4b_p1.png') }}" alt=""
                            class="dota-team-profile"> </span>
                    <span>VS</span>
                    <span><span class="dota-team-name">Team B</span><img src="{{ asset('image/631dfb2793c4b_p1.png') }}" alt=""
                            class="dota-team-profile"></span>
                </div>
                <div class="dota-match-data">
                    <p>13.9.2022</p>
                    <p>02:30PM</p>

                   <div class="win-result">
                    <span class="win-data">W1: 1.2</span>
                    <span class="win-data">W2: 13</span>
                   </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <div>
        @if (Session::has('success'))
            <div class="alert alert-success alert-dismissible fade in">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
                <strong>{{ Session::get('success') }}</strong>
            </div>
        @endif

        <!--main content start-->
        <div class="main-content-parent-container">

            <!--permissions start-->
            <div class="permissions-parent-container">
                <div class="permissions-header">
                    <h1>Permissions</h1>
                    <a href="{{ route('permission.create') }}">
                        <iconify-icon icon="bi:plus" class="create-role-btn-icon"></iconify-icon>
                        <p>Create Permission</p>
                    </a>
                </div>

                <div class="permissions-lists-parent-container">
                    <div class="permissions-list-labels-container">
                        <h2>ID</h2>
                        <h2>Name</h2>

                        <h2>Action</h2>
                    </div>

                    <div class="permissions-list-rows-container">
                        @php
                            $i = 0;
                        @endphp
                        @foreach ($permissions as $permission)
                            <div class="permissions-list-row">
                                <p>{{ ++$i }} </p>
                                <p>{{ $permission->name }}</p>

                                <div class="permissions-list-row-actions">
                                    <!-- <a href="./roleviewdetail.html"><iconify-icon icon="ant-design:exclamation-circle-outlined" class="permissions-list-row-icon"></iconify-icon></a> -->
                                    <a href="{{ route('permission.edit', $permission->id) }}">
                                        <iconify-icon icon="akar-icons:edit" class="permissions-list-row-icon">
                                        </iconify-icon>
                                    </a>
                                    <a href="{{ route('permission.destroy', $permission->id) }}" class="delete-btn">
                                        <iconify-icon icon="fluent:delete-16-regular" class="permissions-list-row-icon">
                                        </iconify-icon>
                                    </a>
                                </div>

                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <!--permissions end-->
        </div>



    </div> --}}
@endsection
