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
            <h1>{{__('msg.Request List - Referee')}}</h1>

            <table class="referee-request-container">
                <thead>
              <tr class="referee-requests-labels-container">
                <th>{{__('msg.No')}}</th>
                <th>{{__('msg.Name')}}</th>
                <th>{{__('msg.Phone Number')}}</th>
                <th>{{__('msg.Op Staff ID')}}</th>
                <th>{{__('msg.Remark')}}</th>
                {{-- <th>{{__('msg.role')}}</th> --}}
                <th></th>
                <th></th>
              </tr>
            </thead>
            <?php $i=1; ?>
              @foreach ($refereerequests as $refereerequest)
              <tr class="referee-request-row">
                <td>{{$i++}}</td>
                <td>{{$refereerequest->name}}</td>
                <td>{{$refereerequest->phone}}</td>
                <td>{{$refereerequest->operationstaff_code}}</td>
                <td class="referee-request-remark">{{$refereerequest->remark}}</td>
                <td>
                <form action="{{route('referee_accept')}}" method="POST" enctype="multipart/form-data" >
                    @csrf
                    <input type="hidden" name="user_id" value="{{$refereerequest->id}}" >
                    <input type="text" name="operationstaff_code" value="{{$refereerequest->operationstaff_code}}" >
                    <input type="hidden" name="remark" value="{{$refereerequest->remark}}">
                    {{-- <p>
                        <select name="role_id" class="referee-request-role-select">
                            <option value=" ">Assign Role</option>
                            @foreach ($roles as $role)
                            <option value="{{$role->id}}">{{$role->name}}</option>
                            @endforeach
                        </select>
                    </p> --}}
                    <button type="submit" class="referee-request-accept-btn" onclick="return confirm('Are you sure to accept?')">{{__('msg.Accept')}}</button>
                {{-- <a href="{{route('referee_accept',$refereerequest->id)}}"><button class="referee-request-accept-btn">Accept</button></a> --}}
                </form>
                </td>
                <td>
                <a href="{{route('referee_decline',[$refereerequest->id])}}" onclick="return confirm('Are you sure to decline?')"><button class="referee-request-decline-btn">{{__('msg.Decline')}}</button></a>
                </td>
            </tr>
              @endforeach
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
