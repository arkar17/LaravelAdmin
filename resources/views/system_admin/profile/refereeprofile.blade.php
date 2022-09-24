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
            <div class="referee-profile-parent-container">
                <h1>{{__('msg.Data - Referee Data - Referee Profile')}}</h1>

            <div class="referee-profile-details-parent-container">
                <div class="referee-profile-details-container">
                    <div class="referee-profile-img-container">
                        <img src="{{asset('/image/'.$referee->image)}}" title="Referee Profile" alt=""/>
                    </div>

                    <div class="referee-profile-attributes-container">
                        <div class="referee-profile-attribute">
                            <h3>{{__('msg.referee')}} {{__('msg.ID')}}</h3>
                            <p>{{$referee->referee_code}}</p>
                        </div>
                        <div class="referee-profile-attribute">
                            <h3>{{__('msg.referee')}}{{__('msg.Name')}}</h3>
                            <p>{{$referee->user->name}}</p>
                        </div>
                        <div class="referee-profile-attribute">
                            <h3>{{__('msg.Phone Number')}}</h3>
                            <p>{{$referee->user->phone}}</p>
                        </div>
                        <div class="referee-profile-attribute">
                            <h3>{{__('msg.Total Sale Amount')}}</h3>
                            <p>{{$sum}}</p>

                        </div>
                    </div>
                </div>
                <div class="referee-profile-chart-container">
                    <p class="chart-label">{{__('msg.Total Sale Amount Of Agents')}}</p>
                    @if(count($agentsaleamounts) !=10)
                    <p>{{__('msg.Your sale list is under 10 transactions. So you can not view the chart')}}</p>
                    @else
                    <canvas id="agchart"></canvas>
                    @endif
                </div>
            </div>

            <div class="section-line">

            </div>

            <div class="referee-profile-agent-list-parent-container">
                <div class="agent-profile-customer-list-labels-container">
                    <h2>{{__('msg.ID')}}</h2>
                    <h2>{{__('msg.Name')}}</h2>
                    <h2>{{__('msg.Phone Number')}}</h2>
                    <h2>{{__('msg.Sale Amount')}}</h2>
                    <h2>{{__('msg.Action')}}</h2>
                </div>
                <div class="referee-profile-agent-list-rows-container">
                    @if ($results == null)
                    <div></div>
                    <?php $i=1; ?>
                    {{-- @foreach ($agents as $agent) --}}
                    @foreach($agents as $agent)
                    <div class="referee-profile-agent-list-row">
                        <p>{{$i++}}</p>
                        <p>{{{$agent->name}}}</p>
                        <p>{{{$agent->phone}}}</p>
                        <p>0</p>
                         <a href="{{route('agentprofile',$agent->id)}}">
                            <iconify-icon icon="ant-design:exclamation-circle-outlined" class="referee-profile-agent-list-btn"></iconify-icon>
                            <p>{{__('msg.View Detail')}}</p>
                        </a>
                    </div>
                    @endforeach
                        @else
                        <?php $i=1; ?>
                        @foreach ($results as $agent)
                        <div class="referee-profile-agent-list-row">

                            <p>{{$i++}}</p>
                            <p>{{{$agent['name']}}}</p>
                            <p>{{{$agent['phone']}}}</p>
                            <p>{{{$agent['Amount']}}}</p>
                             <a href="{{route('agentprofile',$agent['id'])}}">
                                <iconify-icon icon="ant-design:exclamation-circle-outlined" class="referee-profile-agent-list-btn"></iconify-icon>
                                <p>{{__('msg.View Detail')}}</p>
                            </a>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>
        <!--main content end-->
    </div>
@endsection

@push('script')
@section('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        $(document).ready(function() {
            // BarChart//

        var agentdata= @json($agentsaleamounts);
        console.log(agentdata);

      const labels1 = [
        agentdata[0].name,
        agentdata[1].name,
        agentdata[2].name,
        agentdata[3].name,
        agentdata[4].name,
        agentdata[5].name,
        agentdata[6].name,
        agentdata[7].name,
        agentdata[8].name,
        agentdata[9].name,

      ];

      const data1 = {
        labels: labels1,
        datasets: [{
          label: 'Amount',
          backgroundColor: '#EB5E28',
          borderColor: 'rgb(255, 99, 132)',
          data: [ agentdata[0].maincash,  agentdata[1].maincash,agentdata[2].maincash,  agentdata[3].maincash, agentdata[4].maincash,  agentdata[5].maincash, agentdata[6].maincash,  agentdata[7].maincash, agentdata[8].maincash,  agentdata[9].maincash, ]

        }]
      };


      const config1 = {
        type: 'bar',
        data: data1,
        options: {}
      };

      const agChart = new Chart(
        document.getElementById('agchart'),
        config1
      );

})

</script>

@endsection
@endpush
