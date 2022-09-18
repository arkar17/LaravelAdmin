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
            <div class="alert alert-success alert-dismissible fade in">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
                <strong>{{ Session::get('success') }}</strong>
            </div>
        @endif

        <div class="referee-requests-parent-container">
            <h1>Request List - Referee</h1>

            <div class="referee-request-container">
              <div class="referee-requests-labels-container">
                <h2>ID</h2>
                <h2>Name</h2>
                <h2>Phone No.</h2>
                <h2>Op Staff ID</h2>
                <h2>Remark</h2>
                <h2>Role</h2>
              </div>
              @foreach ($refereerequests as $refereerequest)
              <div class="referee-request-row">
                <p>{{$refereerequest->id}}</p>
                <p>{{$refereerequest->name}}</p>
                <p>{{$refereerequest->phone}}</p>
                <p>{{$refereerequest->operationstaff_code}}</p>
                <p>{{$refereerequest->remark}}</p>
                <form action="{{route('referee_accept')}}" method="POST" enctype="multipart/form-data" >
                    @csrf
                <input type="hidden" name="user_id" value="{{$refereerequest->id}}" >
                <input type="text" name="operationstaff_code" value="{{$refereerequest->operationstaff_code}}" >
                <input type="hidden" name="remark" value="{{$refereerequest->remark}}">
                <p>
                    <select name="role_id" class="referee-request-role-select">
                        <option value=" ">Assign Role</option>
                        @foreach ($roles as $role)
                        <option value="{{$role->id}}">{{$role->name}}</option>
                        @endforeach
                    </select>
                </p>
                <button type="submit" class="referee-request-accept-btn">Accept</button>
                {{-- <a href="{{route('referee_accept',$refereerequest->id)}}"><button class="referee-request-accept-btn">Accept</button></a> --}}
                </form>
                <a href="{{route('referee_decline',[$refereerequest->id])}}"><button class="referee-request-decline-btn">Decline</button></a>
              </div>
              @endforeach
            </div>
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
