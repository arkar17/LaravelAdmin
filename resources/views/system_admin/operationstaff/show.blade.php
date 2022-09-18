@extends('system_admin.layouts.app')

@section('title', 'Show Operation Staff')

@section('custom_css')
    <style>
        .client_img {
            width: 120px;
            height: 120px;
            /* border: 2px solid #ddd; */
            /* border-radius: 10px; */
            padding: 3px;
        }
    </style>
@endsection

@section('content')
    <div>
        <!--operation staff view detail start-->
        <div class="role-view-detail-parent-container">
            <h1>Operation-Staff Information</h1>

            <div class="role-view-detail-container">
                <div class="role-view-detail-attributes-container">
                    <div class="role-view-detail-attribute">
                        <img src="{{asset('storage/image/'.$operation_staff->image) }}" class="" alt="">
                    </div>
                    <div class="role-view-detail-attribute">
                        <p>Name:</p>
                        <p>{{$operation_staff->user->name}}</p>
                    </div>
                    <div class="role-view-detail-attribute">
                        <p>Phone:</p>
                        <p> {{ $operation_staff->user->phone }}</p>
                    </div>
                </div>

                <a href="{{url()->previous()}}">Go Back</a>
            </div>
        </div>
    </div>

@endsection


@push('script')
    <script>

    </script>
@endpush
