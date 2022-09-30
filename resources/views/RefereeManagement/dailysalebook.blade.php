@extends('system_admin.layouts.app')

@section('title', '2D Manage')

@section('content')
<style>
    .daily-sale-book-access-alert{
        color: white;
        margin-left: 20px;
        background-color: rgba(18, 179, 18, 0.863);
        border-radius: 5px;
        padding: 5px;
    }
    .daily-sale-book-decline-alert{
        color: white;
        margin-left: 20px;
        background-color: rgba(248, 2, 2, 0.8);
        border-radius: 5px;
        padding: 5px;
    }
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
  <!--daily sale book start-->
  <div class="daily-sale-book-parent-container">
    <h1>{{__('msg.Daily Sale Book')}}</h1>
        @if (Session::has('success'))
                    <div id="hide">
                        <h4 class="daily-sale-book-access-alert">{{Session::get('success')}}<span class="closeBtn">X</span></h4>
                    </div>
        @endif
        @if (Session::has('declined'))
            <div id="hide">
                <h4 class="daily-sale-book-decline-alert">{{Session::get('declined')}}<span class="closeBtn">X</span></h4>
            </div>
        @endif

    <div class="daily-sale-book-headers-container">

        <div class="daily-sale-book-categories-container">
            <p class="daily-sale-book-category daily-sale-book-categories-active" id="2d_sale_list">{{__('msg.2D & Lone Pyine Sale List')}}</p>
            <p class="daily-sale-book-category" id="3d_sale_list">{{__('msg.3D Sale List')}}</p>

        </div>
    </div>

    <div class="daily-sale-book-2d-parent-container">
        <!--2d details start-->
        <div class="daily-sale-book-2dlist-parent-container">
          <h1>{{__('msg.2D')}}</h1>
          <div class="daily-sale-book-2dlist-container">
            <div class="daily-sale-book-2dlist-1row"></div>
            <div class="daily-sale-book-2dlist-2row"></div>
            <div class="daily-sale-book-2dlist-3row"></div>
            <div class="daily-sale-book-2dlist-4row"></div>
            <div class="daily-sale-book-2dlist-5row"></div>
            <div class="daily-sale-book-2dlist-6row"></div>
            <div class="daily-sale-book-2dlist-7row"></div>
            <div class="daily-sale-book-2dlist-8row"></div>
            <div class="daily-sale-book-2dlist-9row"></div>
            <div class="daily-sale-book-2dlist-10row"></div>
            <div class="daily-sale-book-2dlist-11row"></div>
            <div class="daily-sale-book-2dlist-12row"></div>
            <div class="daily-sale-book-2dlist-13row"></div>
          </div>
        </div>
        <!--2d details end-->

        <!--lonepyine start-->
        <div class="daily-sale-book-lonepyinelist-parent-container">
          <h1>{{__('msg.Lone Pyine')}}</h1>
          <div class="daily-sale-book-lonepyinelist-container">
            <div class="daily-sale-book-lonepyinelist-1row"></div>
            <div class="daily-sale-book-lonepyinelist-2row"></div>
            <div class="daily-sale-book-lonepyinelist-3row"></div>
          </div>

        </div>
        <!--lonepyine end-->

        <!--charts start-->
        <div class="daily-sale-book-charts-container">
          <div class="daily-sale-book-2d-chart-container" >
            <p>{{__('msg.Most Bet 2D Number')}}</p>
            @if(count($twod_salelists) !=10 || count($twod_salelists) ==null)
            <p>{{__('msg.Your sale list is under 10 transactions. So you can not view the chart')}}</p>
            @else
                <canvas id="daily-sale-book-2d-chart"></canvas>
            @endif
          </div>

          <div class="daily-sale-book-lonepyine-chart-container">
            <p>{{__('msg.Most Bet Lone Pyine Number')}}</p>

            @if(count($lp_salelists) !=10 || count($lp_salelists) ==null)
            <p>{{__('msg.Your sale list is under 10 transactions. So you can not view the chart')}}</p>
            @else
            <canvas id="daily-sale-book-lonepyine-chart"></canvas>
            @endif
          </div>
        </div>
        <!--charts end-->
        @if(count($agenttwodsaleList) != 0 ||  count($agentlonepyinesalelist) != 0 )
      <div class="daily-sale-book-sale-record-parent-container">
          <h1>{{__('msg.2D & Lone Pyine Sale Record')}}</h1>
          <table class="daily-sale-book-sale-record-container">
            <thead>
            <tr class="daily-sale-book-sale-record-labels-container">
              <th>{{__('msg.ID')}}</th>
              {{-- <th>Date</th> --}}
              <th>{{__('msg.Agent')}} {{__('msg.Name')}}</th>
              <th>{{__('msg.Round')}}</th>
              <th>{{__('msg.Type')}}</th>
              <th>{{__('msg.Number')}}</th>
              <th>{{__('msg.Compensation')}}</th>
              <th>{{__('msg.Amount')}}</th>
              <th>{{__('msg.Action')}}</th>
            </tr>
            </thead>
            <tbody class="daily-sale-book-sale-record-rows-container">
                        <?php $i=1;?>
                        @foreach ($agenttwodsaleList as $agent)


                            <tr class="daily-sale-book-sale-record-row">
                                <td>{{$i++}}</td>
                                {{-- <td>{{$agent->date}}</td> --}}
                                <td>{{$agent->name}}</td>
                                <td>{{$agent->round}}</td>
                                <td>{{__('msg.2D')}}</td>
                                <td class="daily-sale-book-sale-row-numbers">
                                    @for ($i=0; $i<=count($numbergroup[$agent->name])-1; $i++)
                                    <p>{{{ $numbergroup[$agent->name][$i] }}}</p><br>
                                    @endfor
                                </td>
                                <td class="daily-sale-book-sale-row-compensations">
                                    @for ($i=0; $i<=count($compengroup[$agent->name])-1; $i++)
                                    <p>{{{ $compengroup[$agent->name][$i] }}}</p><br>
                                    @endfor
                                </td>
                                <td class="daily-sale-book-sale-row-amounts">
                                    @for ($i=0; $i<=count($salegroup[$agent->name])-1; $i++)
                                    <p>{{{ $salegroup[$agent->name][$i] }}}</p><br>
                                    @endfor
                                </td>

                                <td class="daily-sale-book-row-btn-container">
                                    <form action="{{route('acceptTwod')}}" mehtod = 'post'>
                                        @csrf
                                        @for ($i=0; $i<=count($idgroup[$agent->name])-1; $i++)
                                    <input type="text" hidden name="id[]" id="" value ="{{{ $idgroup[$agent->name][$i] }}}">
                                    <input type="text" hidden name="agent_id" id="" value ="{{$agent->agent_id}}">
                                        @endfor
                                            <button class="daily-sale-book-accept-btn">{{__('msg.Accept')}}</button>
                                    </form>
                                    <form action="{{route('declineTwod')}}" mehtod = 'post'>
                                        @csrf
                                        @for ($i=0; $i<=count($idgroup[$agent->name])-1; $i++)
                                    <input type="text" hidden name="id[]" id="" value ="{{{ $idgroup[$agent->name][$i] }}}">
                                    <input type="text" hidden name="agent_id" id="" value ="{{$agent->agent_id}}">
                                        @endfor

                                            <button class="daily-sale-book-decline-btn">{{__('msg.Decline')}}</button>

                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        @foreach($agentlonepyinesalelist as $agent)
                            <tr class="daily-sale-book-sale-record-row">
                                <td>{{$agent->id}}</td>
                                {{-- <td>{{$agent->date}}</td> --}}
                                <td>{{$agent->name}}</td>
                                <td>{{$agent->round}}</td>
                                <td>{{__('msg.Lone Pyine')}}</td>

                                <td class="daily-sale-book-sale-row-numbers">
                                    @for ($i=0; $i<=count($lp_numbergroup[$agent->name])-1; $i++)
                                    <p>{{{ $lp_numbergroup[$agent->name][$i] }}}</p><br>
                                    @endfor
                                </td>
                                <td class="daily-sale-book-sale-row-compensations">
                                    @for ($i=0; $i<=count($lp_compengroup[$agent->name])-1; $i++)
                                    <p>{{{ $lp_compengroup[$agent->name][$i] }}}</p><br>
                                    @endfor
                                </td>
                                <td class="daily-sale-book-sale-row-amounts">
                                    @for ($i=0; $i<=count($lp_salegroup[$agent->name])-1; $i++)
                                    <p>{{{ $lp_salegroup[$agent->name][$i] }}}</p><br>
                                    @endfor
                                </td>
                                <td class="daily-sale-book-row-btn-container">
                                    <form action="{{route('acceptlp')}}" mehtod = 'post'>
                                        @csrf
                                        @for ($i=0; $i<=count($lp_idgroup[$agent->name])-1; $i++)
                                    <input type="text" hidden name="id[]" id="" value ="{{{ $lp_idgroup[$agent->name][$i] }}}">
                                    <input type="text" hidden name="agent_id" id="" value ="{{$agent->agent_id}}">
                                        @endfor


                                            <button class="daily-sale-book-accept-btn">Accept</button>


                                    </form>
                                    <form action="{{route('declinelp')}}" mehtod = 'post'>
                                        @csrf
                                        @for ($i=0; $i<=count($lp_idgroup[$agent->name])-1; $i++)
                                    <input type="text" hidden name="id[]" id="" value ="{{{ $lp_idgroup[$agent->name][$i] }}}">
                                    <input type="text" hidden name="agent_id" id="" value ="{{$agent->agent_id}}">
                                        @endfor


                                            <button class="daily-sale-book-decline-btn">Decline</button>

                                    </form>
                                </td>
                            </tr>
                        @endforeach
            </tbody>

          </table>
        </div>
        @endif
    </div>


    <div class="daily-sale-book-3d-parent-container">
                        @if($rate == [])
                            <p class="daily-sale-book-3d-current-rate">{{__('msg.Current Rate')}} : 0</p>

                        @else
                            @foreach($rate as $rat)
                            <p class="daily-sale-book-3d-current-rate">{{__('msg.Current Rate')}}  : {{$rat->compensation}}</p>
                            @endforeach
                        @endif

      <div class="daily-sale-book-3d-chart-container">
        <p>{{__('msg.Most Bet 3D Numbers')}}</p>
        @if(count($threed_salelists) !=10 || count($threed_salelists) ==null)
            <p>{{__('msg.Your sale list is under 10 transactions. So you can not view the chart')}}</p>
        @else
            <canvas id="daily-sale-book-3d-chart"></canvas>
        @endif
      </div>

      @if(count($agentthreedsalelist) != 0)
      <!--sale record start-->
      <div class="daily-sale-book-sale-record-parent-container">
        <h1>{{__('msg.3D sale record list')}}</h1>
        <table class="daily-sale-book-sale-record-container">
            <thead>
          <tr class="daily-sale-book-sale-record-labels-container">
            <th>{{__('msg.ID')}}</th>
            {{-- <th>Date</th> --}}
            <th>{{__('msg.Agent')}} {{__('msg.Name')}}</th>
            <th>{{__('msg.Type')}}</th>
            <th>{{__('msg.Number')}}</th>
            <th>{{__('msg.Compensation')}}</th>
            <th>{{__('msg.Amount')}}</th>
            <th>{{__('msg.Action')}}</th>
          </tr>
            </thead>
          <tbody class="daily-sale-book-sale-record-rows-container">
            @foreach ($agentthreedsalelist as $agent)
                <tr class="daily-sale-book-sale-record-row">
                    <td>{{$agent->id}}</td>
                    <td>{{$agent->name}}</td>
                    <td>{{__('msg.3D')}}</td>
                    <td class="daily-sale-book-sale-row-numbers">
                        @for ($i=0; $i<=count($threed_numbergroup[$agent->name])-1; $i++)
                        <p>{{{ $threed_numbergroup[$agent->name][$i] }}}</p><br>
                        @endfor
                    </td>
                    <td class="daily-sale-book-sale-row-compensations">
                        @for ($i=0; $i<=count($threed_compengroup[$agent->name])-1; $i++)
                        <p>{{{ $threed_compengroup[$agent->name][$i] }}}</p><br>
                        @endfor
                    </td>
                    <td class="daily-sale-book-sale-row-amounts">
                        @for ($i=0; $i<=count($threed_salegroup[$agent->name])-1; $i++)
                        <p>{{{ $threed_salegroup[$agent->name][$i] }}}</p><br>
                        @endfor
                    </td>

                    <td class="daily-sale-book-row-btn-container">
                        <form action="{{route('acceptThreed')}}" mehtod = 'post'>
                            @csrf
                            @for ($i=0; $i<=count($threed_idgroup[$agent->name])-1; $i++)
                        <input type="text" hidden name="id[]" id="" value ="{{{ $threed_idgroup[$agent->name][$i] }}}">
                        <input type="text" hidden name="agent_id" id="" value ="{{$agent->agent_id}}">
                            @endfor


                                <button class="daily-sale-book-accept-btn">Accept</button>


                        </form>
                        <form action="{{route('declineThreed')}}" mehtod = 'post'>
                            @csrf
                            @for ($i=0; $i<=count($threed_idgroup[$agent->name])-1; $i++)
                        <input type="text" hidden name="id[]" id="" value ="{{{ $threed_idgroup[$agent->name][$i] }}}">
                        <input type="text" hidden name="agent_id" id="" value ="{{$agent->agent_id}}">
                            @endfor


                                <button class="daily-sale-book-decline-btn">Decline</button>

                        </form>
                    </td>
                </tr>
            @endforeach

          </tbody>

        </table>
      </div>
      @endif
      <!--sale record end-->
    </div>
</div>


            <script src="{{asset('jquery/refereemanage/dailysalebook.js')}}"></script>
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@endsection

@section('script')
<script>

    $(document).ready(function(){
        var twod_data = @json($twod_salelists);
        console.log(twod_data);
        var lp_data =  @json($lp_salelists);
        console.log(lp_data);
        var threed_data = @json($threed_salelists);
        console.log(threed_data);
        const labels1 = [
        twod_data[0].number,
        twod_data[1].number,
        twod_data[2].number,
        twod_data[3].number,
        twod_data[4].number,
        twod_data[5].number,
        twod_data[6].number,
        twod_data[7].number,
        twod_data[8].number,
        twod_data[9].number
      ];
      const data1 = {
        labels: labels1,
        datasets: [{
          label: '{{__('msg.Most Bet 2D Number')}}',
          backgroundColor: '#EB5E28',
          borderColor: 'rgb(255, 99, 132)',
          data: [ twod_data[0].sale_amount,  twod_data[1].sale_amount,  twod_data[2].sale_amount,  twod_data[3].sale_amount,  twod_data[4].sale_amount,  twod_data[5].sale_amount,  twod_data[6].sale_amount,  twod_data[7].sale_amount, twod_data[8].sale_amount, twod_data[9].sale_amount]

        }]
      };
      const config1 = {
        type: 'bar',
        data: data1,
        options: {}
      };
      const twodChart = new Chart(
        document.getElementById('daily-sale-book-2d-chart'),
        config1
      );

      const labels2 = [
        lp_data[0].number,
        lp_data[1].number,
        lp_data[2].number,
        lp_data[3].number,
        lp_data[4].number,
        lp_data[5].number,
        lp_data[6].number,
        lp_data[7].number,
        lp_data[8].number,
        lp_data[9].number,
      ];
      const data2 = {
        labels: labels2,
        datasets: [{
          label: '{{__('msg.Most Bet Lone Pyine Number')}}',
          backgroundColor: '#EB5E28',
          borderColor: 'rgb(255, 99, 132)',
         data: [ lp_data[0].sale_amount,  lp_data[1].sale_amount,  lp_data[2].sale_amount,  lp_data[3].sale_amount,  lp_data[4].sale_amount,  lp_data[5].sale_amount,  lp_data[6].sale_amount,  lp_data[7].sale_amount, lp_data[8].sale_amount, lp_data[9].sale_amount],

        }]
      };
      const config2 = {
        type: 'bar',
        data: data2,
        options: {}
      };

      const lonepyineChart = new Chart(
        document.getElementById('daily-sale-book-lonepyine-chart'),
        config2
      );


      const labels3 = [
        threed_data[0].number,
        threed_data[1].number,
        threed_data[2].number,
        threed_data[3].number,
        threed_data[4].number,
        threed_data[5].number,
        threed_data[6].number,
        threed_data[7].number,
        threed_data[8].number,
        threed_data[9].number
      ];

      const data3 = {
        labels: labels3,
        datasets: [{
          label: '{{__('msg.Most Bet 3D Number')}}',
          backgroundColor: '#EB5E28',
          borderColor: 'rgb(255, 99, 132)',
          data: [ threed_data[0].sale_amount,  threed_data[1].sale_amount,  threed_data[2].sale_amount,  threed_data[3].sale_amount,  threed_data[4].sale_amount,  threed_data[5].sale_amount,  threed_data[6].sale_amount,  threed_data[7].sale_amount, threed_data[8].sale_amount, threed_data[9].sale_amount]

        }]
      };

      const config3 = {
        type: 'bar',
        data: data3,
        options: {}
      };



      const threeChart = new Chart(
        document.getElementById('daily-sale-book-3d-chart'),
        config3
      );
})




</script>

@endsection


