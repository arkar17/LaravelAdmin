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

        <div class="referee-requests-parent-container">
            <h1>{{__('msg.Request List - Operation Staff')}}</h1>

            <table class="referee-request-container">
                <thead>
                    <tr class="referee-requests-labels-container">
                        <th>{{__('msg.ID')}}</th>
                        <th>{{__('msg.Name')}}</th>
                        <th>{{__('msg.Phone Number')}}</th>
                        <th>{{__('msg.Remark')}}</th>
                        <th></th>
                        {{-- <th></th> --}}

                    </tr>
                </thead>
                <tbody>
              @foreach ($operationstaffs as $operationstaff )

              <tr class="referee-request-row">
                <td>{{$operationstaff->id}}</td>
                <td>{{$operationstaff->name}}</td>
                <td>{{$operationstaff->phone}}</td>
                <td class="referee-request-remark">{{$operationstaff->remark}}</td>
                <td>
                    <div class="request-btn-container">
                    <a href="{{route('operationaccept',$operationstaff->id)}}"><button class="referee-request-accept-btn">{{__('msg.Accept')}}</button></a>

                    <a  class="decline-btn" href="{{route('operationdecline',$operationstaff->id)}}"><button class="referee-request-decline-btn">{{__('msg.Decline')}}</button></a>
                    </div>
                </td>
              </tr>
              @endforeach
            </tbody>
            </table>
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
