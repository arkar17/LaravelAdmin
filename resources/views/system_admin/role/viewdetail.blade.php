@extends('system_admin.layouts.app')

@section('title', 'Create Role')

@section('content')
    <div>
        <!--role view detail start-->
        <div class="role-view-detail-parent-container">
            <h1>View Detail</h1>

            <div class="role-view-detail-container">
                <div class="role-view-detail-attributes-container">
                    <div class="role-view-detail-attribute">
                        <p>ID:</p>
                        <p>{{$role->id}}</p>
                    </div>
                    <div class="role-view-detail-attribute">
                        <p>Name:</p>
                        <p>{{$role->name}}</p>
                    </div>
                    <div class="role-view-detail-attribute">
                        <p>Joined Date:</p>
                        <p> {{date('d M Y',strtotime($role->created_at))}}</p>
                    </div>
                    <div class="role-view-detail-permissions-parent-container">
                        <p>Assingned Permissions:</p>
                        <div class="role-view-detail-permissions-container">
                            @foreach ($permissions as $key=>$value)
                                <p>{{$value}}</p>
                            @endforeach
                        </div>
                    </div>
                </div>

                <a href="{{url()->previous()}}">Go Back</a>
            </div>
        </div>
        <!-- role view detail end-->
    </div>

@endsection
