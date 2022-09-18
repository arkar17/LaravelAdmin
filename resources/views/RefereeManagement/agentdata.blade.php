@extends('RefereeManagement.layout.app')

@section('title', 'Agent Data')

@section('content')
            <!--agent data start-->
            <div class="agent-data-parent-container">
                <h1>Data - agent Data</h1>

                <div class="agent-data-list-parent-container">
                  <div class="agent-data-list-labels-container">
                    <h2>ID</h2>
                    <h2>Name</h2>
                    <h2>Phone No.</h2>
                    <!-- <h2>Operation Staff</h2> -->
                    <h2>No. of Customers</h2>
                  </div>

                  <div class="agent-data-list-rows-container">
                   @foreach ($agentdata as $data)
                    <div class="agent-data-list-row">

                            <p>{{$data->id}}</p>
                            <p>{{$data->name}}</p>
                            <p>{{$data->phone}}</p>
                            <!-- <p>Op Staff 01</p> -->
                            <p>{{$data->NumOfCus}}</p>
                            <a href="{{route('agentprofiledetail',[$data->id])}}">
                            <iconify-icon icon="ant-design:exclamation-circle-outlined" class="agent-data-list-viewdetail-btn"></iconify-icon>
                            View Detail
                            </a >

                    </div>
                   @endforeach
                  </div>
                </div>
              </div>
            <!--agent data end-->
@endsection

@push('script')
    <script>

    </script>
@endpush
