@extends('system_admin.layouts.app')

@section('title', 'Edit Permission')

@section('content')
    <div>
        <!--main content start-->
        <div class="main-content-parent-container">
            <!-- create permission start-->
            <div class="create-permission-parent-container">
                <h1>Edit Permission</h1>
                <div class="create-permission-outer-container">
                    <div class="create-permission-inner-container">
                        <form action="{{ route('permission.update', $permission->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <p>Enter Permission Name:</p>
                        <input type="text" value="{{$permission->name}}" name="name"/>
                        <div class="create-permission-btn-container">
                            <button class="submit">Edit</button>
                            <button class="reset">Cancel</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- create permission end-->
        </div>
        <!--main content end-->
    </div>

@endsection
