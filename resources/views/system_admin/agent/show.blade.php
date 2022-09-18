@extends('system_admin.layouts.app')

@section('title', 'Show Agent')

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
        <section class="box">
            <header class="panel_header">
                <h2 class="title pull-left"> <i class="fa-solid fa-shield-halved"></i> &nbsp; Agent Information</h2>
            </header>
            <div class="content-body">
                <div class="text-center">
                    <img src="{{ asset('storage/agent/' . $agent->image) }}" class="client_img" alt="">
                </div>
                <div>
                    <p>Name: {{ $agent->name }}</p>
                    <p>Phone: {{ $agent->phone }}</p>
                </div>
            </div>
        </section>
    </div>

@endsection


@push('script')
    <script>

    </script>
@endpush
