@extends('system_admin.layouts.app')

@section('title', 'Permission')

@section('content')

    <div>
        @if (Session::has('success'))
        <div id="hide">
            <h4 class="main-cash-alert"> {{ Session::get('success') }} <span class="closeBtn">X</span> </h4>
        </div>
        @endif

        <!--main content start-->
        <div class="main-content-parent-container">

            <!--permissions start-->
            <div class="permissions-parent-container">
                <div class="permissions-header">
                    <h1>{{__('msg.permission')}}</h1>
                    <a href="{{ route('permission.create') }}">
                        <iconify-icon icon="bi:plus" class="create-role-btn-icon"></iconify-icon>
                        <p>{{__('msg.Create permission')}}</p>
                    </a>
                </div>

                <div class="permissions-lists-parent-container">
                    <div class="permissions-list-labels-container">
                        <h2>{{__('msg.ID')}}</h2>
                        <h2>{{__('msg.Name')}}</h2>

                        <h2>{{__('msg.Action')}}</h2>
                    </div>

                    <div class="permissions-list-rows-container">
                        @php
                            $i = 0;
                        @endphp
                        @foreach ($permissions as $permission)
                            <div class="permissions-list-row">
                                <p>{{ ++$i }} </p>
                                <p>{{ $permission->name }}</p>

                                <div class="permissions-list-row-actions">
                                    <!-- <a href="./roleviewdetail.html"><iconify-icon icon="ant-design:exclamation-circle-outlined" class="permissions-list-row-icon"></iconify-icon></a> -->
                                    <a href="{{ route('permission.edit', $permission->id) }}">
                                        <iconify-icon icon="akar-icons:edit" class="permissions-list-row-icon">
                                        </iconify-icon>
                                    </a>
                                    <a href="{{ route('permission.destroy', $permission->id) }}" class="delete-btn" onclick="return confirm('Are you sure you want to delete this ?')">
                                        <iconify-icon icon="fluent:delete-16-regular" class="permissions-list-row-icon">
                                        </iconify-icon>
                                    </a>
                                </div>

                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <!--permissions end-->
        </div>



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
                                url: `/permission/${id}`
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
