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
                    <canvas id="agchart"></canvas>
                </div>
            </div>

            <div class="section-line">

            </div>

            <table class="referee-profile-agent-list-parent-container">
                {{-- sadkfhdsofudsfgdui --}}
                <thead>
                <tr class="agent-profile-customer-list-labels-container">
                    <th>{{__('msg.ID')}}</th>
                    <th>{{__('msg.Name')}}</th>
                    <th>{{__('msg.Phone Number')}}</th>
                    <th>{{__('msg.Sale Amount')}}</th>
                    <th>{{__('msg.Action')}}</th>
                </tr>
                </thead>
                <tbody class="referee-profile-agent-list-rows-container">
                    @if ($results == null)
                    <div></div>
                    @foreach ($agents as $agent)

                    <tr class="referee-profile-agent-list-row">
                        <td>{{$agent->id}}</td>
                        <td>{{{$agent->name}}}</td>
                        <td>{{{$agent->phone}}}</td>
                        <td>0</td>
                        <td>
                         <a href="{{route('agentprofile',$agent->id)}}">
                            <iconify-icon icon="ant-design:exclamation-circle-outlined" class="referee-profile-agent-list-btn"></iconify-icon>
                            <p>{{__('msg.View Detail')}}</p>
                        </a>
                        </td>
                    </tr>
                    @endforeach
                        @else

                        @foreach ($results as $agent)
                        <tr class="referee-profile-agent-list-row">

                            <td>{{$agent['id']}}</td>
                            <td>{{{$agent['name']}}}</td>
                            <td>{{{$agent['phone']}}}</td>
                            <td>{{{$agent['Amount']}}}</td>
                            <td>
                             <a href="{{route('agentprofile',$agent['id'])}}">
                                <iconify-icon icon="ant-design:exclamation-circle-outlined" class="referee-profile-agent-list-btn"></iconify-icon>
                                <p>{{__('View Detail')}}</p>
                            </a>
                            </td>
                        </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        <!--main content end-->
    </div>
@endsection

@push('script')
@section('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

            // BarChart//

        var agentdata= @json($agentsaleamounts);
        console.log(agentdata);

      const labels1 = [
        agentdata[0].maincash,
        agentdata[1].maincash,
        agentdata[2].maincash,
        agentdata[3].maincash,
        agentdata[4].maincash,
        agentdata[5].maincash,
        agentdata[6].maincash,
        agentdata[7].maincash,

      ];

      const data1 = {
        labels: labels1,
        datasets: [{
          label: 'Amount',
          backgroundColor: '#EB5E28',
          borderColor: 'rgb(255, 99, 132)',
          data: [ agentdata[0].maincash,  agentdata[1].maincash,  agentdata[2].maincash,  agentdata[3].maincash]

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
