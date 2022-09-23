@extends('system_admin.layouts.app')

@section('title', 'Referee Profile')

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
            <div class="referee-profile-parent-container">
                <h1>{{__('msg.Admin Profile')}}</h1>
            <div class="referee-profile-details-parent-container">
                <div class="referee-profile-details-container">

                    <div class="referee-profile-attributes-container">
                        <div class="referee-profile-attribute">
                            <h3>{{__('msg.Name')}}</h3>
                            <p>{{auth()->user()->name}}</p>
                        </div>
                        <div class="referee-profile-attribute">
                            <h3>{{__('msg.Phone Number')}}</h3>
                            <p>{{auth()->user()->phone}}</p>
                        </div>
                    </div>
                </div>
            </div>

        <!--main content end-->
    </div>
@endsection

@push('script')
@section('script')

@endsection
@endpush
