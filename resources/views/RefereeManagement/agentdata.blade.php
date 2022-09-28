@extends('RefereeManagement.layout.app')

@section('title', 'Agent Data')

@section('content')
            <!--agent data start-->
            <div class="agent-data-parent-container">
                <h1>{{__('msg.Agent Data')}}</h1>

                <table class="agent-data-list-parent-container">
                    <thead>
                        <tr class="agent-data-list-labels-container">
                            <th>{{__('msg.ID')}}</th>
                            <th>{{__('msg.Name')}}</th>
                            <th>{{__('msg.Phone Number')}}</th>
                            <!-- <th>Operation Staff</th> -->
                            <th>{{__('msg.No. of Customers')}}</th>
                            <th></th>
                        </tr>
                    </thead>

                  <tbody class="agent-data-list-rows-container">
                   @foreach ($agentdata as $data)
                    <tr class="agent-data-list-row">

                            <td>{{$data->id}}</td>
                            <td>{{$data->name}}</td>
                            <td>{{$data->phone}}</td>
                            <!-- <td>Op Staff 01</td> -->
                            <td>{{$data->NumOfCus}}</td>
                            <td>
                            <a href="{{route('agentprofiledetail',[$data->id])}}">
                            <iconify-icon icon="ant-design:exclamation-circle-outlined" class="agent-data-list-viewdetail-btn"></iconify-icon>
                            {{__('msg.View Detail')}}
                            </a >
                            </td>

                    </tr>
                   @endforeach
                  </tbody>
                </table>
            </div>
            <!--agent data end-->
@endsection

@push('script')
    <script>

    </script>
@endpush
