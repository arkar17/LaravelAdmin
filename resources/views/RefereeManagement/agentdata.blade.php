@extends('system_admin.layouts.app')

@section('title', 'Agent Data')

@section('content')
            <!--agent data start-->
            <div class="agent-data-parent-container">
                <h1>{{__('msg.Agent Data')}}</h1>

                <div class="agent-data-list-parent-container">
                  <div class="agent-data-list-labels-container">
                    <h2>{{__('msg.ID')}}</h2>
                    <h2>{{__('msg.Name')}}</h2>
                    <h2>{{__('msg.Phone Number')}}</h2>
                    <h2>{{__('msg.No. of Customers')}}</h2>
                  </div>

                  <div class="agent-data-list-rows-container">
                    @if (count($agentdata) ==null || count($agentdata) ==0)
                        <p style="text-align: center;">{{__('msg.Not have agents data')}}</p>
                        @else
                        <?php $i=1;?>
                        @foreach ($agentdata as $data)
                                <div class="agent-data-list-row">
                                    <p>{{$i++}}</p>
                                    <p>{{$data->name}}</p>
                                    <p>{{$data->phone}}</p>
                                    <!-- <p>Op Staff 01</p> -->
                                    <p>{{$data->NumOfCus}}</p>
                                    <a href="{{route('agentprofiledetail',[$data->id])}}">
                                    <iconify-icon icon="ant-design:exclamation-circle-outlined" class="agent-data-list-viewdetail-btn"></iconify-icon>
                                    {{__('msg.View Detail')}}
                                    </a >
                                </div>
                        @endforeach
                   @endif
                  </div>
                </div>
              </div>
            <!--agent data end-->
@endsection

@push('script')
    <script>

    </script>
@endpush
