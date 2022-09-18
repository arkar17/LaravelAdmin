@extends('system_admin.layouts.app')

@section('title', 'Create Role')

@section('content')
    <div>
        <!--main content- start-->
        <!--Create role start-->
        <div class="create-role-parent-container">
            <h1>Create Role</h1>
            <div class="create-role-container">
                <form action="{{ route('role.store') }}" method="POST">
                    @csrf
                    <div class="create-role-name-container">
                        <p>Enter Role Name:</p>
                        <input type="text" placeholder="Role Name" name="name" />
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
                                                    value="{{ $permission->name }}" />
                                                <label for="{{ $permission->name }}">{{ $permission->name }}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="create-permission-btn-container">
                        <button type="submit">Create</button>
                        <button type="reset">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
        <!--create role end-->
        <!--main content-end-->


    </div>

@endsection
