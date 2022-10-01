@extends('system_admin.layouts.app')

@section('title', 'Referees')

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
                <div id="hide">
                    <h4 class="main-cash-alert"> {{ Session::get('success') }} <span class="closeBtn">X</span> </h4>
                </div>
        @endif
        <div class="section-line"></div>

        <!--referee list start-->
        <div class="referee-list-parent-container">
            <h1>{{__('msg.Referee List')}}</h1>
            {{-- <a href="{{route('export_excel')}}">Export excel</a>
            <a href="{{route('export_pdf')}}">Export pdf</a> --}}

            <table class="referee-list-container">
                <thead>
                <tr class="referee-list-labels-container">
                    <th>{{__('msg.Code')}}</th>
                    <th>{{__('msg.Name')}}</th>
                    <th>{{__('msg.Phone Number')}}</th>
                    <th>{{__('msg.Opstaff Code')}}</th>
                    <th>{{__('msg.role')}}</th>
                    <th>{{__('msg.Active Status')}}</th>
                    {{-- <th>Image</th> --}}
                    <th>{{__('msg.Action')}}</th>

                </tr>
                </thead>

                <tbody class="referee-list-rows-container">
                    @foreach ($referees as $referee)
                        <tr class="referee-list-row">
                            <td>{{$referee->referee_code}}</td>
                            <td>{{$referee->user->name}}</td>
                            <td>{{$referee->user->phone}}</td>
                            <td>{{$referee->operationstaff->operationstaff_code}}</td>
                            <td>
                               {{($referee->user->getRoleNames())}}
                            </td>
                                @if ($referee->active_status == 1)
                                <td class="text-success">Active</td>
                                @else
                                <td class="text-secondary">Inactive</td>
                                @endif
                            {{-- <p>
                                <img src="{{asset('storage/image/'.$referee->image)}}">
                            </p> --}}
                            <td class="referee-list-row-actions-container">
                                <a href="{{route('refreeprofile',$referee->id)}}">
                                    <iconify-icon icon="ant-design:exclamation-circle-outlined" class="referee-list-row-icon"></iconify-icon>
                                </a>
                                <a href="{{route('referee.edit',$referee->id)}}">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </a>
                                <a href="{{route('referee.destroy',$referee->id)}}" onclick="return confirm('Are you sure you want to delete this ?')">
                                    <i class="fa-regular fa-trash-can"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
    <script>
    $('#operationstaff-id').on('click',function() {

        var sel=document.getElementById('operationstaff-id');
        console.log(sel.value);

    });

        </script>
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
                                url: `/referee/${id}`
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
