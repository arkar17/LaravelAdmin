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

              <table class="roles-lists-parent-container">
                <thead>
                <tr class="roles-list-labels-container">
                  <th>{{__('msg.ID')}}</th>
                  <th>{{__('msg.Name')}}</th>
                  <th>{{__('msg.Date')}}</th>
                  <th>{{__('msg.Action')}}</th>
                </tr>
                </thead>

                <tbody class="roles-list-rows-container">
                    @php
                    $i = 0;
                    @endphp
                    @foreach ($roles as $role)
                  <tr class="roles-list-row">
                    <td>{{$i++}}</td>
                    <td>{{$role->name}}</td>
                    <td> {{date('d.m.y',strtotime($role->created_at))}}</td>
                    <td class="roles-list-row-actions">
                      <a href="{{route('role.show',$role->id)}}"><iconify-icon icon="ant-design:exclamation-circle-outlined" class="roles-list-row-icon"></iconify-icon></a>
                      <a href="{{ route('role.edit', $role->id) }}"><iconify-icon icon="akar-icons:edit" class="roles-list-row-icon"></iconify-icon></a>
                      {{-- <a href="{{route('role.destroy',$role->id)}}"><iconify-icon icon="fluent:delete-16-regular" class="roles-list-row-icon"></iconify-icon></a> --}}
                    </td>
                </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <!--roles end-->

    </div>
@endsection

@push('script')

@endpush
