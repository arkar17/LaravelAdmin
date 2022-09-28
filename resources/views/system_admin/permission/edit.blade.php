@extends('system_admin.layouts.app')

@section('title', 'Edit Permission')

@section('content')
    <div>
        <!--main content start-->
        <div class="main-content-parent-container">
            <!-- create permission start-->
            <div class="create-permission-parent-container">
                <h1>{{__('msg.Edit Permission')}}</h1>
                <div class="create-permission-outer-container">
                    <div class="create-permission-inner-container">
                        <form action="{{ route('permission.update', $permission->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <p>{{__('msg.Enter Permission Name')}}:</p>
                        <input type="text" value="{{$permission->name}}" name="name"/>
                        <div class="create-permission-btn-container">
                            <button type="submit">{{__('msg.Save')}}</button>
                            <button type="reset" onclick="javascript:history.back()">{{__('msg.Cancel')}}</button>
                        </div>
                        </form>
                        @if (Session::has('success'))
                        <div id="hide">
                            <h4 class="main-cash-alert"> {{ Session::get('success') }} <span class="closeBtn">X</span> </h4>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <!-- create permission end-->
        </div>
        <!--main content end-->
    </div>

@endsection
