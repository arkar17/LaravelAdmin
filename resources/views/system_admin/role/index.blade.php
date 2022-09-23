@extends('system_admin.layouts.app')

@section('title', 'Role')

@section('content')

    <div>
        @if (Session::has('success'))
        <div id="hide">
            <h4 class="main-cash-alert"> {{ Session::get('success') }} <span class="closeBtn">X</span> </h4>
        </div>
        @endif


            <!--roles start-->
            <div class="roles-parent-container">
              <div class="roles-header">

                <h1>{{__('msg.role')}}</h1>
                <a href="{{route('role.create')}}">
                  <iconify-icon icon="bi:plus" class="create-role-btn-icon"></iconify-icon>
                  <p>{{__('msg.Create Role')}}</p>
                </a>
              </div>

              <div class="roles-lists-parent-container">
                <div class="roles-list-labels-container">
                  <h2>{{__('msg.ID')}}</h2>
                  <h2>{{__('msg.Name')}}</h2>
                  <h2>{{__('msg.Date')}}</h2>
                  <h2>{{__('msg.Action')}}</h2>
                </div>

                <div class="roles-list-rows-container">
                    @php
                    $i = 0;
                    @endphp
                    @foreach ($roles as $role)
                  <div class="roles-list-row">
                    <p>{{$i++}}</p>
                    <p>{{$role->name}}</p>
                    <p> {{date('d.m.y',strtotime($role->created_at))}}</p>
                    <div class="roles-list-row-actions">
                      <a href="{{route('role.show',$role->id)}}"><iconify-icon icon="ant-design:exclamation-circle-outlined" class="roles-list-row-icon"></iconify-icon></a>
                      <a href="{{ route('role.edit', $role->id) }}"><iconify-icon icon="akar-icons:edit" class="roles-list-row-icon"></iconify-icon></a>
                      <a href="{{route('role.destroy',$role->id)}}" onclick="return confirm('Are you sure you want to delete this ?')"><iconify-icon icon="fluent:delete-16-regular" class="roles-list-row-icon"></iconify-icon></a>
                    </div>
                  </div>
                  @endforeach
                </div>
              </div>
            </div>
            <!--roles end-->

    </div>
@endsection

@push('script')

@endpush
