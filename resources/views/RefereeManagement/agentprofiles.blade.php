@extends('RefereeManagement.layout.app')

@section('title', 'Agent Data')

@section('content')

    <div>
        @if (Session::has('success'))
            <div class="alert alert-success alert-dismissible fade in">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
                <strong>{{ Session::get('success') }}</strong>
            </div>
        @endif

        @if (Session::has('commision'))
        <div class="alert alert-success alert-dismissible fade show my-3" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <strong>{{ Session::get('commision') }}</strong>
        </div>
        @endif
        <!--main content start-->
        <div class="main-content-parent-container">
            <!--referee profile start-->
            <div class="agent-profile-parent-container">
                <h1>{{__('msg.Agent Profile')}}</h1>

                <div class="agent-profile-filters-container">
                    {{-- <input id="agent-profile-filter-fromdate" type="date" placeholder="From Date" />
                    <input id="agent-profile-filter-todate" type="date" placeholder="To Date" /> --}}

                    <button class="agent-profile-filter-btn">
                        <iconify-icon icon="ant-design:search-outlined" class="agent-data-filter-btn-icon"></iconify-icon>
                        <p>Filter</p>
                    </button>

                    <button class="agent-profile-edit-comission-btn">{{__('msg.Edit Commission')}}</button>

                    <form action="{{route('agentcommsionupdate',[$agentprofiledata->id])}}" method="post" class="agent-profile-commission-container">
                        @csrf
                        <div class="agent-profile-commission">
                            <input  name="editagentcomssion" id="floatingInput" type="number" placeholder="Edit comssion amount" aria-label="default input example">
                            <button type="submit">{{__('msg.Edit')}}</button>
                        </div>
                    </form>


                </div>

                <div class="agent-profile-details-parent-container">
                    <div class="agent-profile-details-container">
                        <div class="agent-profile-img-container">
                            <img src="{{asset('/image'.$agentprofiledata->image)}}"/>
                        </div>

                        <div class="agent-profile-attributes-container">
                            <div class="agent-profile-attribute">
                                <h3>{{__('msg.ID')}}</h3>
                                <p>{{$agentprofiledata->id}}</p>
                            </div>
                            <div class="agent-profile-attribute">
                                <h3>{{__('msg.Agent')}}{{__('msg.Name')}}</h3>
                                <p>{{$agentprofiledata->name}}</p>
                            </div>
                            <div class="agent-profile-attribute">
                                <h3>{{__('msg.Phone Number')}}</h3>
                                <p>{{$agentprofiledata->phone}}</p>
                            </div>
                            <div class="agent-profile-attribute">
                                <h3>{{__('msg.Total Sale Amount')}}</h3>
                                <p>{{$totalamount}}ks</p>
                            </div>
                            <div class="agent-profile-attribute">
                                <h3>{{__('msg.Commision')}}</h3>
                                @if ($commision == null)
                                    <p>0</p>
                                @else
                                <p>{{$commision->commision}}</p>
                                @endif

                            </div>
                        </div>
                    </div>
                    <div class="agent-profile-chart-container">
                        <p class="chart-label">{{__('msg.Total Sale Amount Of Customers')}}</p>
                        <canvas id="cuschart"></canvas>
                    </div>
                </div>

                <div class="section-line">

                </div>

                <div class="agent-profile-agent-list-parent-container">
                    {{-- <form action="{{route('agentcustomersearch',[$agentprofiledata->id])}}" method="post"> --}}
                        @csrf
                        <div class="agent-profile-agent-list-header">
                            <h1>{{__('msg.Agent')}} {{$agentprofiledata->name}}'s {{__('msg.Customer List')}}</h1>
                        </div>

                        <table class="agent-profile-agent-list-container">
                            <thead>
                            <tr class="agent-profile-agent-list-labels-container">
                                <th>{{__('msg.ID')}}</th>
                                <th>{{__('msg.Name')}}</th>
                                <th>{{__('msg.Phone Number')}}</th>
                                <th>{{__('msg.Number')}}</th>
                                <th>{{__('msg.Compensation')}}</th>
                                <th>{{__('msg.Amount')}}</th>
                            </tr>
                            </thead>

                            <tbody class="agent-profile-agent-list-rows-container">
                                {{-- @for ($i=0; $i<=count($twodnum)-1; $i++) --}}
                                    @foreach ($agentcustomerdata as $data)
                                        <tr class="agent-profile-agent-list-row">
                                            <td>{{$data->id}}</td>
                                            <td>{{$data->customer_name}}</td>
                                            <td>{{$data->customer_phone}}</td>
                                            <td>{{$data->number}}</td>
                                            <td>{{$data->compensation}}</td>
                                            <td>{{$data->sale_amount}}ks</td>
                                        </tr>
                                    @endforeach
                                {{-- @endfor --}}
                                    </tbody>
                        </table>
                    </form>
                </div>

            </div>
            <!--referee profile end-->
        </div>


        <!--main content end-->
    </div>
@endsection


@section('script')
{{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"> --}}
<script>
 $(document).ready(function() {


    $(".agent-profile-edit-comission-btn").click(function(){
        $(".agent-profile-commission-container").toggle()
    })

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
        data: [ twodata[0].maincash,twodata[1].maincash,twodata[2].maincash,twodata[3].maincash,lonepyinedata[0].maincash,lonepyinedata[1].maincash,lonepyinedata[2].maincash,threedata[0].maincash,threedata[1].maincash]

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
