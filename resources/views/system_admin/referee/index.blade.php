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

            <div class="referee-list-container">
            <div class="referee-list-labels-container">
                <h2>{{__('msg.ID')}}</h2>
                <h2>{{__('msg.Name')}}</h2>
                <h2>{{__('msg.Phone Number')}}</h2>
                <h2>{{__('msg.Opstaff Code')}}</h2>
                <h2>{{__('msg.role')}}</h2>
                <h2>{{__('msg.Active Status')}}</h2>
                {{-- <h2>Image</h2> --}}
                <h2>{{__('msg.Action')}}</h2>

            </div>

            <div class="referee-list-rows-container">
                @foreach ($referees as $referee)
                    <div class="referee-list-row">
                        <p>{{$referee->referee_code}}</p>
                        <p>{{$referee->user->name}}</p>
                        <p>{{$referee->user->phone}}</p>
                        <p>{{$referee->operationstaff->operationstaff_code}}</p>
                        <p>role {{$referee->role_id}}</p>
                            @if ($referee->active_status == 1)
                            <p class="text-success">Active</p>
                            @else
                            <p class="text-secondary">Inactive</p>
                            @endif
                        {{-- <p>
                            <img src="{{asset('storage/image/'.$referee->image)}}">
                        </p> --}}
                        <div class="referee-list-row-actions-container">
                            <a href="{{route('refreeprofile',$referee->id)}}">
                                <iconify-icon icon="ant-design:exclamation-circle-outlined" class="referee-list-row-icon"></iconify-icon>
                            </a>
                            <a href="{{route('referee.edit',$referee->id)}}">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </a>
                            <a href="{{route('referee.destroy',$referee->id)}}" onclick="return confirm('Are you sure you want to delete this ?')">
                                <i class="fa-regular fa-trash-can"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            </div>

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
