@extends('system_admin.layouts.app')

@section('title', 'Create Permission')

@section('content')
    <div>
        <!--main content start-->
      <div class="main-content-parent-container">
        <!-- create permission start-->
        <div class="create-permission-parent-container">
            <h1>{{__('msg.Create Permission')}}</h1>
            <div class="create-permission-outer-container">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li style="color: red; list-style: none;">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                <div class="create-permission-inner-container">
                    <form action="{{ route('permission.store') }}" method="POST">
                        @csrf
                        <div class="create-permission-category-container">
                            {{-- <label for="permission-categories">Choose Permission:</label>
                            <select name="status" id="permission-categories">
                                <option></option>
                                <option value="2D">2D</option>
                                <option value="3D">3D</option>
                            </select> --}}
                        </div>
                    <p>{{__('msg.Enter Permission Name')}}:</p>
                    <input type="text" name="name" required/>
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
        </div>
        <!-- create permission end-->
      </div>
      <!--main content end-->
    </div>

@endsection
