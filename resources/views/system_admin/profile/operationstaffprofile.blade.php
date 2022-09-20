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
            <!--referee profile start-->
            <div class="op-profile-parent-container">
                <h1>{{__('msg.Data - Operation Staff Data - Operation Staff Profile')}}</h1>
            <div class="op-profile-details-parent-container">
                <div class="op-profile-details-container">
                    <div class="op-profile-img-container">
                        <img src="{{asset('storage/image/'.$operationstaff->image)}}" title="Referee Profile" alt=""/>
                    </div>

                    <div class="op-profile-attributes-container">
                        <div class="op-profile-attribute">
                            <h3>{{__('msg.Operation Staff')}} {{__('msg.ID')}}</h3>
                            <p>{{$operationstaff->operationstaff_code}}</p>
                        </div>
                        <div class="op-profile-attribute">
                            <h3>{{__('msg.Operation Staff')}}{{__('msg.Name')}}</h3>
                            <p>{{$operationstaff->user->name}}</p>
                        </div>
                        <div class="op-profile-attribute">
                            <h3>{{__('msg.Phone Number')}}</h3>
                            <p>{{$operationstaff->user->phone}}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="section-line">

            </div>

            <div class="op-profile-referee-list-parent-container">
                <div class="op-profile-referee-list-header">
                    <h1>{{$operationstaff->operationstaff_code}} {{__('msg.Referee List')}}</h1>
                </div>

                <div class="op-profile-referee-list-container">
                    <div class="op-profile-referee-list-labels-container">
                        <h2>{{__('msg.referee')}} {{__('msg.Code')}}</h2>
                        <h2>{{__('msg.Name')}}</h2>
                        <h2>{{__('msg.Phone Number')}}</h2>
                    </div>

                    <div class="op-profile-referee-list-rows-container">
                        @foreach ($referees as $referee)
                        <div class="op-profile-referee-list-row">
                            <p>{{$referee->referee_code}}</p>
                            <p>{{$referee->user->name}}</p>
                            <p>{{$referee->user->phone}}</p>
                            <a href="{{route('refreeprofile',$referee->id)}}">
                                <iconify-icon icon="ant-design:exclamation-circle-outlined" class="op-profile-referee-list-btn"></iconify-icon>
                                <p>{{__('msg.View Detail')}}</p>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        <!--main content end-->
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
