@extends('system_admin.layouts.app')

@section('title', 'Role')

@section('content')

    <div>
        @if (Session::has('success'))
            <div class="alert alert-success alert-dismissible fade in">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
                <strong>{{ Session::get('success') }}</strong>
            </div>
        @endif


            <!--roles start-->
            <div class="roles-parent-container">
              <div class="roles-header">

                <h1>Roles</h1>
                <a href="{{route('role.create')}}">
                  <iconify-icon icon="bi:plus" class="create-role-btn-icon"></iconify-icon>
                  <p>Create Role</p>
                </a>
              </div>

              <div class="roles-lists-parent-container">
                <div class="roles-list-labels-container">
                  <h2>ID</h2>
                  <h2>Name</h2>
                  <h2>Date</h2>
                  <h2>Action</h2>
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
                      {{-- <a href="{{route('role.destroy',$role->id)}}"><iconify-icon icon="fluent:delete-16-regular" class="roles-list-row-icon"></iconify-icon></a> --}}
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
    <script>
        $(document).ready(function() {
            var table = $('.table');
            $(document).on('click', '.delete-btn', function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                swal({
                        text: "Are you sure you want to delete?",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                method: "DELETE",
                                url: `/role/${id}`
                            }).done(function(res) {
                                location.reload();
                                console.log("deleted");
                            })
                        } else {
                            swal("Your imaginary file is safe!");
                        }
                    });
            })
        })
    </script>
@endpush
