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
            <div class="agent-profile-parent-container">
                <h1>{{__('msg.Data - Agent Data - Agent Profile')}}</h1>
            <div class="agent-profile-details-parent-container">
                <div class="agent-profile-details-container">
                    <div class="agent-profile-img-container">
                        <img src="{{asset('/image/'.$agent->image)}}" title="Agent Profile" alt=""/>
                    </div>

                    <div class="agent-profile-attributes-container">
                        <div class="agent-profile-attribute">
                            <h3>{{__('msg.ID')}}</h3>
                            <p>AG{{$agent->id}}</p>
                        </div>
                        <div class="agent-profile-attribute">
                            <h3>{{__('msg.Agent')}} {{__('msg.Name')}}</h3>
                            <p>{{$agent->user->name}}</p>
                        </div>
                        <div class="agent-profile-attribute">
                            <h3>{{__('msg.Phone Number')}}</h3>
                            <p>{{$agent->user->phone}}</p>
                        </div>
                        <div class="agent-profile-attribute">
                            <h3>{{__('msg.referee')}} {{__('msg.Code')}}</h3>
                            <p>{{$agent->referee->referee_code}}</p>
                        </div>
                        <div class="agent-profile-attribute">
                            <h3>{{__('msg.Total Sale Amount')}}</h3>
                            <p>{{$sum}}</p>
                        </div>
                    </div>
                </div>
                <div class="agent-profile-chart-container">
                    <p class="chart-label">{{__('msg.Total Sale Amount')}}{{__('msg.Customers')}} </p>
                    <canvas id="cuschart"></canvas>
                </div>
            </div>
            <div class="agent-profile-customer-list-parent-container">
                <div class="agent-profile-customer-list-header">
                    <h1>{{$agent->user->name}} {{__('msg.Customer List')}}</h1>

                    <div class="export-btns-container">
                        <a href="{{route('customer.export_excel',$agent->id)}}">Export excel </a>

                        <a href="{{route('customer.export_pdf',$agent->id)}}">Export pdf</a>
                    </div>

                </div>

                <table class="agent-profile-customer-list-container">
                    <thead>
                        <tr class="agent-profile-customer-list-labels-container">
                            <th>{{__('msg.ID')}}</th>
                            <th>{{__('msg.Name')}}</th>
                            <th>{{__('msg.Phone Number')}}</th>
                            <th>{{__('msg.Sale Amount')}}</th>
                        </tr>
                    </thead>
                    <?php
                    $i=1;
                    ?>
                    <tbody class="agent-profile-customer-list-rows-container">
                        @if ($results == null)

                        @else
                            @foreach ($results as $result)
                            <tr class="agent-profile-customer-list-row">
                                <td>{{$i++}}</td>
                                <td>{{$result['customer_name']}}</td>
                                <td>{{$result['customer_phone']}}</td>
                                <td>{{$result['Amount']}}</td>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>

        </div>

        <!--main content end-->
    </div>

    <script>
        $(document).ready(function() {

 // BarChart//

    var twodata= @json($twocus);
    var threedata=@json($threecus);
    var lonepyinedata=@json($lpcus);
    console.log(twodata);
    console.log(threedata);
    console.log(lonepyinedata);

      const labels1 = [
        twodata[0].customer_name,
        twodata[1].customer_name,
        twodata[2].customer_name,
        lonepyinedata[0].customer_name,
        lonepyinedata[1].customer_name,
        lonepyinedata[2].customer_name,
        threedata[0].customer_name,
        threedata[1].customer_name,
        threedata[2].customer_name,
      ];
      const data1 = {
        labels: labels1,
        datasets: [{
          label: 'Amount',
          backgroundColor: '#EB5E28',
          borderColor: 'rgb(255, 99, 132)',
          data: [ twodata[0].maincash,twodata[1].maincash,twodata[2].maincash,lonepyinedata[0].maincash,lonepyinedata[1].maincash,lonepyinedata[2].maincash,threedata[0].maincash,threedata[1].maincash,threedata[2].maincash]

        }]
      };


      const config1 = {
        type: 'bar',
        data: data1,
        options: {}
      };

      const agChart = new Chart(
        document.getElementById('cuschart'),
        config1
      );
        })
    </script>

@endsection

@push('script')
@section('script')


    @endsection
@endpush
