@extends('system_admin.layouts.app')

@section('title', 'Edit Role')

@section('content')
    <div>
        <!--Create role start-->
        <div class="create-role-parent-container">
            <h1>Edit Role</h1>

            <div class="create-role-container">
                <form action="{{ route('role.update', $role->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                <div class="create-role-name-container">
                    <p>Enter Role Name:</p>
                    <input type="text" placeholder="Role Name"  value="{{ old('name', $role->name) }}"  name="name" autofocus/>
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="create-role-permission-parent-container">
                    <p class="create-role-permission-label">
                        Choose Permission for this role:
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
                        {{-- <div class="create-role-permission-list-row">
                            <p>2D</p>

                            <div class="create-role-permission-checkboxes-container">
                            @foreach ($permissions2ds as $permissions2d)
                                <div class="create-role-permission-list-row-checkbox-container ">

                                    <input tabindex="5" type="checkbox" id="{{$permissions2d->name}}"
                                            name="permissions2d[]" class="icheck-minimal-blue" value="{{ $permissions2d->name }}"
                                            @if (in_array($permissions2d->id, $old_permissions2d)) checked @endif>
                                        <label class="icheck-label form-label" for="{{ $permissions2d->name }}">{{ $permissions2d->name }}</label>
                                </div>
                            @endforeach
                            </div>

                        </div> --}}
                    </div>
                </div>
                <div class="create-permission-btn-container">
                    <button type="submit">Edit</button>
                    <button type="reset">Cancel</button>
                </div>
                </form>
            </div>
        </div>
        <!--create role end-->


    </div>

@endsection
