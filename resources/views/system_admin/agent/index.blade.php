@extends('system_admin.layouts.app')

@section('title', 'Agents')

@section('custom_css')
    <style>
        .client_img {
            width: 60px;
            height: 60px;
            border: 2px solid #ddd;
            border-radius: 10px !important;
            padding: 3px;
        }
    </style>
@endsection

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
                <h2 class="title pull-left">Agents</h2>
                <div class="actions panel_actions pull-right">

                    <a href="{{ route('agent.create') }}" class="">
                        <button class="btn btn-info"> <i class="fa fa-plus"></i> &nbsp; Create New</button>
                    </a>

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
                                        <th class="text-center">ID</th>
                                        <th class="text-center">Name</th>
                                        <th class="text-center">Phone</th>
                                        <th class="text-center">Coin Amount</th>
                                        <th class="text-center">Commision</th>
                                        <th class="text-center">Image</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                @php
                                    $i = 0;
                                @endphp
                                <tbody>
                                    @foreach ($agents as $agent)
                                    <tr>
                                        <td class="text-center">{{ ++$i }}</td>
                                        <td class="text-center"> {{$agent->name}} </td>
                                        <td class="text-center">{{$agent->phone}}</td>
                                        <td class="text-center">{{$agent->coin_amount}}</td>
                                        <td class="text-center">{{ $agent->commision }}</td>
                                        <td class="text-center">
                                            <a href="">
                                                <img src="{{ asset('storage/agent/' . $agent->image) }}" class="client_img"  alt="">
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('agent.edit', $agent->id) }}" class="" title="edit">
                                                <i class="fa-solid fa-pen-to-square text-warning fa-lg"
                                                    style="margin: 0px 5px"></i> </a>

                                            <a href="{{ route('agent.show', $agent->id) }}" class="" title="detail">
                                                <i class="fa-solid fa-info-circle text-info fa-lg"
                                                    style="margin: 0px 5px"></i> </a>

                                            <a href="{{ route('agent.destroy', $agent->id) }}" title="delete"
                                                class="delete-btn" data-id="{{ $agent->id }}" > <i
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
                                url: `/agent/${id}`
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
