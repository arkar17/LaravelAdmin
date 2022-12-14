@extends('system_admin.layouts.app')

@section('title', 'Agent Data')

@section('content')
     <style>
        #hide {
            margin-top: 10px;
        }
        .closeBtn {
            color: white;
            cursor: pointer;
            float: right;
            margin-right: 20px;
            margin-top: 2px;
        }
     </style>
    <div>

        @if (Session::has('commision'))
        <div class="alert alert-success alert-dismissible fade show my-3" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <strong>{{ Session::get('commision') }}</strong>
        </div>
        @endif

            <!--referee profile start-->
            <div class="agent-profile-parent-container">
                <h1>{{__('msg.Agent Profile')}}</h1>

                @if (Session::has('commisionEditSucess'))
                    <div id="hide">
                        <h4 class="agent-profile-commission-edit">{{Session::get('commisionEditSucess')}}<span class="closeBtn">X</span></h4>
                    </div>
                @endif

                <div class="agent-profile-filters-container">

                    <button class="agent-profile-edit-comission-btn">{{__('msg.Edit Commision')}}</button>

                    <form action="{{route('agentcommsionupdate',[$agentprofiledata->id])}}" method="post" class="agent-profile-commission-container">
                        @csrf
                        <div class="agent-profile-commission">
                            <input  name="editagentcomssion" id="floatingInput" type="number" placeholder="Edit commision amount" aria-label="default input example" required>
                            <button type="submit">{{__('msg.Edit')}}</button>
                        </div>
                    </form>


                </div>

                <div class="agent-profile-details-parent-container">
                    <div class="agent-profile-details-container">
                        <div class="agent-profile-img-container">
                            <img src="{{asset('/image/'.$agentprofiledata->image)}}"/>
                        </div>

                        <div class="agent-profile-attributes-container">
                            <div class="agent-profile-attribute">
                                <h3>{{__('msg.AgID')}}</h3>
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
                                @if($sum == null || $sum ==0)
                                    <p>0 {{__('msg.ks')}}</p>
                                @else
                                    <p>{{$sum}} {{__('msg.ks')}}</p>

                                @endif

                            </div>
                            <div class="agent-profile-attribute">
                                <h3>{{__('msg.Commision')}}</h3>
                                @if ($commision->commision == null)
                                    <p>0 {{__('msg.percent')}}</p>
                                @else
                                <p>{{$commision->commision}} {{__('msg.percent')}}  &nbsp; ( &nbsp;
                                    @if($commisions == null || $commisions ==0)
                                    0 {{__('msg.ks')}}
                                @else
                                    {{$commisions}} {{__('msg.ks')}}

                                @endif
                                 &nbsp; )
                                </p>
                                @endif

                            </div>
                        </div>
                    </div>
                    <div class="agent-profile-chart-container">
                        <p class="chart-label">{{__('msg.Total Sale Amount Of Customers')}}</p>
                        @if (count($twocus)!=3 || count($threecus)!=3 || count($lpcus)!=3)
                            <p style="text-align: center;">{{__('msg.Your sale list 2D, 3D and Lone pyine in one of the three is less transactions. So you can not view the chart')}}</p>
                        @else
                            <canvas id="cuschart"></canvas>
                        @endif
                    </div>
                </div>

                <div class="section-line">

                </div>

                <div class="agent-profile-agent-list-parent-container">
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

                                @if ($agentCustomerData ==null)
                                    <tr><th style="text-align: center;">{{__('msg.You not have customer')}}</th></tr>
                                @else
                                <?php $i=1;?>

                                    @foreach ($agentCustomerData as $data)
                                        <tr class="agent-profile-agent-list-row">
                                            <td>{{$i++}}</td>
                                            <td>{{$data['customer_name']}}</td>
                                            <td>{{$data['customer_phone']}}</td>
                                            <td>{{$data['number']}}</td>
                                            <td>{{$data['compensation']}}</td>
                                            <td>{{$data['Amount']}}</td>

                                        </tr>
                                    @endforeach

                                @endif
                            </tbody>
                        </table>
                </div>

            </div>
            <!--referee profile end-->

    </div>

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

