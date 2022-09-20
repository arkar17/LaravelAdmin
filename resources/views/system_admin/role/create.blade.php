@extends('system_admin.layouts.app')

@section('title', 'Create Role')

@section('content')
    <div>
        <!--main content- start-->
        <!--Create role start-->
        <div class="create-role-parent-container">
            <h1>{{__('msg.Create')}} {{__('msg.Role')}}</h1>
            <div class="create-role-container">
                <form action="{{ route('role.store') }}" method="POST">
                    @csrf
                    <div class="create-role-name-container">
                        <p>{{__('msg.Enter Role Name')}}:</p>
                        <input type="text" placeholder="Role Name" name="name" />
                    </div>

                    <div class="create-role-permission-parent-container">
                        <p class="create-role-permission-label">
                            {{__('msg.Choose Permission for this role')}}:
                        </p>

                        <div class="create-role-permission-list-container">
                            <div class="create-role-permission-list-row">
                                @foreach ($permissions as $permission)
                                    <div class="create-role-permission-checkboxes-container">
                                        <div class="create-role-permission-list-row-checkbox-container ">
                                                <input type="checkbox" name="permissions[]" id="{{ $permission->name }}"
                                                    value="{{ $permission->name }}" />
                                                <label for="{{ $permission->name }}">{{ $permission->name }}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="create-permission-btn-container">
                        <button type="submit">{{__('msg.Create')}}</button>
                        <button type="reset" onclick="javascript:history.back()">{{__('msg.Cancel')}}</button>
                    </div>
                    @if (Session::has('success'))
                    <div id="hide">
                        <h4 class="main-cash-alert"> {{ Session::get('success') }} <span class="closeBtn">X</span> </h4>
                    </div>
                    @endif
                </form>
            </div>
        </div>
        <!--create role end-->
        <!--main content-end-->


    </div>

@endsection
