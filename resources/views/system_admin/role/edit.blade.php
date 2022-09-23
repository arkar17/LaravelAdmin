@extends('system_admin.layouts.app')

@section('title', 'Edit Role')

@section('content')
    <div>
        <!--Create role start-->
        <div class="create-role-parent-container">
            <h1>{{__('msg.Edit')}} {{__('msg.Role')}}</h1>

            <div class="create-role-container">
                <form action="{{ route('role.update', $role->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                <div class="create-role-name-container">
                    <p>{{__('msg.Enter Role Name')}}:</p>
                    <input type="text" placeholder="Role Name"  value="{{ old('name', $role->name) }}"  name="name" autofocus/>
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
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
                                                value="{{ $permission->name }}"
                                                 @if (in_array($permission->id, $old_permissions)) checked @endif/>
                                            <label for="{{ $permission->name }}">{{ $permission->name }}</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>
                <div class="create-permission-btn-container">
                    <button type="submit">{{__('msg.Save')}}</button>
                    <button type="reset" onclick="javascript:history.back()">{{__('msg.Cancel')}}</button>
                </div>
                </form>

            </div>
        </div>
        <!--create role end-->


    </div>

@endsection
