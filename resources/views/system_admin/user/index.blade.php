@extends('system_admin.layouts.app')

@section('title', 'Users')

@section('content')

    <div>
        @if (Session::has('success'))
            <div class="alert alert-success alert-dismissible fade in">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
                <strong>{{ Session::get('success') }}</strong>
            </div>
        @endif

        <section class="box">
            <header class="panel_header">
                <h2 class="title pull-left">Users</h2>
                <div class="actions panel_actions pull-right">

                    <a href="{{ route('user.create') }}" class="">
                        <button class="btn btn-info"> <i class="fa fa-plus"></i> &nbsp; Create New</button>
                    </a>
                    {{-- <a class="box_toggle fa fa-chevron-down"></a>
                    <a class="box_setting fa fa-cog" data-toggle="modal" href="#section-settings"></a>
                    <a class="box_close fa fa-times"></a> --}}
                </div>
            </header>
            <div class="content-body">
                <div class="row">
                    <div class="col-xs-12">

                        <div class="table-responsive" data-pattern="priority-columns">
                            <table id="tech-companies-1"
                                class="table vm table-small-font no-mb table-bordered table-striped ">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Role</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                @php
                                    $i = 0;
                                @endphp
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td> {{ ++$i }} </td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->phone }}</td>
                                            <td>
                                                @foreach ($user->roles as $role)
                                                    <span class="badge badge-info">
                                                        {{ $role->name }}
                                                    </span>
                                                @endforeach
                                            </td>
                                            <td>

                                                <a href="{{ route('user.edit', $user->id) }}" class="" title="edit">
                                                    <i class="fa-solid fa-pen-to-square text-warning fa-lg"
                                                        style="margin: 0px 5px"></i> </a>

                                                <a href="{{ route('user.show', $user->id) }}" class="" title="detail">
                                                    <i class="fa-solid fa-info-circle text-info fa-lg"
                                                        style="margin: 0px 5px"></i> </a>

                                                <a href="{{ route('user.destroy', $user->id) }}" title="delete"
                                                    class="delete-btn" data-id="{{ $user->id }}"> <i
                                                        class="fa-solid fa-trash text-danger fa-lg"
                                                        style="margin: 0px 5px"></i> </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </section>
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
