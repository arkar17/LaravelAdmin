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
              <h1>{{__('msg.Data - Referee Data')}}</h1>

              <table class="referee-data-list-parent-container">
                <thead>
                    <tr class="referee-data-list-labels-container">
                    <th>{{__('msg.Referee ID')}}</th>
                    <th>{{__('msg.Name')}}</th>
                    <th>{{__('msg.Phone Number')}}</th>
                    <th>{{__('operationstaff')}}</th>
                    <th>{{__('msg.No. of Agents')}}</th>
                    <th></th>
                    {{-- <h2>Action</h2> --}}
                    </tr>
                </thead>

                <tbody class="referee-data-list-rows-container">
                    @foreach ($referees as $referee)
                    {{-- @foreach ($referees as $referee) --}}

                    <tr class="referee-data-list-row">
                        <td>{{$referee->referee_code}}</td>
                        <td>{{$referee->name}}</td>
                        <td>{{$referee->phone}}</td>
                        <td>{{$referee->operationstaff_code}}</td>
                        <td>{{$referee->agentcount}}</td>
                        <td>
                        <a href="{{route('refreeprofile',$referee->id)}}">
                          <iconify-icon icon="ant-design:exclamation-circle-outlined" class="referee-data-list-viewdetail-btn"></iconify-icon>
                         {{__('msg.View Detail')}}
                        </a >
                        </td>
                    </tr>

                    @endforeach
                    {{-- @endforeach --}}
                </tbody>
              </table>
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
