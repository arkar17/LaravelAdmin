@extends('system_admin.layouts.app')

@section('title', 'Permission')

@section('content')

    <div>
        @if (Session::has('success'))
            <div class="alert alert-success alert-dismissible fade in">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
                <strong>{{ Session::get('success') }}</strong>
            </div>
        @endif

             <!--main content start-->
        {{-- <div class="main-content-parent-container"> --}}

            <!--referee data start-->
            <div class="referee-data-parent-container">
              <h1>Data - Referee Data</h1>

              <div class="referee-data-list-parent-container">
                <div class="referee-data-list-labels-container">
                  <h2>Referee ID</h2>
                  <h2>Name</h2>
                  <h2>Phone No.</h2>
                  <h2>Operation Staff</h2>
                  <h2>No. of Agents</h2>
                  {{-- <h2>Action</h2> --}}
                </div>

                <div class="referee-data-list-rows-container">
                    @foreach ($referees as $referee)
                    {{-- @foreach ($referees as $referee) --}}

                    <div class="referee-data-list-row">
                        <p>{{$referee->referee_code}}</p>
                        <p>{{$referee->name}}</p>
                        <p>{{$referee->phone}}</p>
                        <p>{{$referee->operationstaff_code}}</p>
                        <p>{{$referee->agentcount}}</p>
                        <a href="{{route('refreeprofile',$referee->id)}}">
                          <iconify-icon icon="ant-design:exclamation-circle-outlined" class="referee-data-list-viewdetail-btn"></iconify-icon>
                          View Detail
                        </a >
                    </div>

                    @endforeach
                    {{-- @endforeach --}}
                </div>
              </div>
            </div>

            <!--referee data end-->
          </div>
          <!--main content end-->
    {{-- </div> --}}
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
