@extends('system_admin.layouts.app')


@section('content')
<div class="main-content-parent-container" style = "margin-bottom: 10px">
    <!--dashboard start-->
    <button class="referee-remark-btn">{{__('msg.Remark')}}</button>
    <div class="referee-remark-popup-parent-container">
        <div class="referee-remark-popup-container ">
            <div class="referee-remark-popup">
                <div class="referee-remark-popup-header">
                    <p>{{__('msg.Remark')}}</p>
                    <iconify-icon icon="akar-icons:cross" class="referee-remark-icon"></iconify-icon>
                </div>

                <form class="referee-remark-input-container" action="{{route('announcement')}}" method = "get">
                    @csrf
                    <textarea name = "remark"></textarea>
                    <div class="referee-remark-input-btns-container">
                        <button type = "submit" class="referee-remark-confirm-btn">{{__('msg.Submit')}}</button>
                        {{-- <button class="referee-remark-cancel-btn">Cancel</button> --}}
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="dashboard-gradient-boxes-container">


        <div class="dashboard-gradient-registeration-container">
            <iconify-icon icon="lucide:user-plus" class="dashboard-registeration-icon"></iconify-icon>
            <p class="dashboard-gradient-label">{{__('msg.Total Sale Amount')}}</p>
            <p class="dashboard-gradient-stat">{{$sum}}</p>
        </div>
        <div class="dashboard-gradient-traffic-container">
            <iconify-icon icon="tabler:activity-heartbeat" class="dashboard-traffic-icon"></iconify-icon>
            <p class="dashboard-gradient-label">{{__('msg.Total No. Of Agent')}}</p>
            <p class="dashboard-gradient-stat">{{count($agents)}}</p>
        </div>
        <div class="dashboard-gradient-referee-container">
            <iconify-icon icon="majesticons:users-line" class="dashboard-referee-icon"></iconify-icon>
            <p class="dashboard-gradient-label">{{__('msg.Total Commision')}}</p>
            <p class="dashboard-gradient-stat">{{$totalcommision}}</p>
        </div>
        <div class="dashboard-gradient-sale-container">
            <iconify-icon icon="bi:currency-dollar" class="dashboard-sale-icon"></iconify-icon>
            <p class="dashboard-gradient-label">{{__('msg.Total Profit')}}</p>
            <p class="dashboard-gradient-stat">{{$totalprofit}}</p>
        </div>
    </div>

    <div class="dashboard-bar-charts-parent-container">
      <div class="dashboard-2d-chart-container">
        <p class="chart-label">{{__('msg.Most Bet 2D Number')}}</p>
        <canvas id="2dchart"></canvas>
      </div>

      <div class="dashboard-lonepyine-container">
        <p class="chart-label">{{__('msg.Most Bet Lone Pyine Number')}}</p>
        <canvas id="lonepyinechart"></canvas>
      </div>
    </div>
    <h1>2D {{__('msg.Declined List')}}</h1>
    <a class="twod-sale-export-btn"
    href="{{route('twoddecline.export_pdf')}}">
           Export 2D Declined List
    </a>
    <div class="twod-sale-list-details-parent-container">
        <div class="twod-sale-list-details-labels-container">
          <p>{{__('msg.ID')}}</p>
          <p>{{__('msg.Agent')}} {{__('msg.Name')}}</p>
          <p>{{__('msg.Number')}}</p>
          <p>{{__('msg.Max Amount')}}</p>
          <p>{{__('msg.Amount')}}</p>
        </div>

        <div class="twod-sale-details-rows-container" >
            <?php  $i = 1 ?>
            @foreach ($Declined_twoDList as $declined)
                <div class="twod-sale-details-row">
                    <p>{{$i++}}</p>
                    <p>{{$declined->name}}</p>
                    <p>{{$declined->number}}</p>
                    <p>{{$declined->max_amount}}</p>
                    <p style="color:red">{{$declined->sales}}</p>
                </div>
            @endforeach

        </div>
    </div>

    <a class="twod-sale-export-btn"
    href="{{route('lonepyinedecline.export_pdf')}}">
           Export Lone Pyine Declined List
    </a>
    <div class="twod-sale-list-details-parent-container">
        <div class="twod-sale-list-details-labels-container">
          <p>{{__('msg.ID')}}</p>
          <p>{{__('msg.Agent')}} {{__('msg.Name')}}</p>
          <p>{{__('msg.Number')}}</p>
          <p>{{__('msg.Max Amount')}}</p>
          <p>{{__('msg.Amount')}}</p>
        </div>

        <div class="twod-sale-details-rows-container" >
            <?php  $i = 1 ?>
            @foreach ($Declined_lonepyineList as $declined)
                <div class="twod-sale-details-row">
                    <p>{{$i++}}</p>
                    <p>{{$declined->name}}</p>
                    <p>{{$declined->number}}</p>
                    <p>{{$declined->max_amount}}</p>
                    <p style="color:red">{{$declined->sales}}</p>
                </div>
            @endforeach

        </div>
    </div>

  </div>
@endsection


@section('script')
<script>

    $(document).ready(function(){

        // console.log("dashboard")

        $(".referee-remark-btn").click(function(){
        // console.log("show")
        $(".referee-remark-popup-parent-container").show()
        })

        $(".referee-remark-icon").click(function(){
            $(".referee-remark-popup-parent-container").hide()
        })

        var twod_data = @json($twod_salelists);
        console.log(twod_data);
        var lp_data =  @json($lp_salelists);
        console.log(lp_data);
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
      const data1 = {
        labels: labels1,
        datasets: [{
          label: 'Amount',
          backgroundColor: '#EB5E28',
          borderColor: 'rgb(255, 99, 132)',
          data: [ twod_data[0].sale_amount,  twod_data[1].sale_amount,  twod_data[2].sale_amount,  twod_data[3].sale_amount,  twod_data[4].sale_amount,  twod_data[5].sale_amount,  twod_data[6].sale_amount,  twod_data[7].sale_amount, twod_data[8].sale_amount, twod_data[9].sale_amount]

        }]
      };
      const data2 = {
        labels: labels2,
        datasets: [{
          label: 'Amount',
          backgroundColor: '#EB5E28',
          borderColor: 'rgb(255, 99, 132)',
         data: [ lp_data[0].sale_amount,  lp_data[1].sale_amount,  lp_data[2].sale_amount,  lp_data[3].sale_amount,  lp_data[4].sale_amount,  lp_data[5].sale_amount,  lp_data[6].sale_amount,  lp_data[7].sale_amount, lp_data[8].sale_amount, lp_data[9].sale_amount],

        }]
      };

      const config1 = {
        type: 'bar',
        data: data1,
        options: {}
      };
      const config2 = {
        type: 'bar',
        data: data2,
        options: {}
      };

      const twodChart = new Chart(
        document.getElementById('2dchart'),
        config1
      );
      const lonepyineChart = new Chart(
        document.getElementById('lonepyinechart'),
        config2
      );



    // const popupbtn = document.querySelector('.referee-remark-btn')

    // popupbtn.addEventListener("click", () => {
    //     console.log("clicked")
    // })
})

//     $(document).ready(function(){
//         var twod_data = @json($twod_salelists);
//         var lp_data =  @json($lp_salelists);
//     const labels1 = [
//         twod_data[0].number,
//         twod_data[1].number,
//         twod_data[2].number,
//         twod_data[3].number,
//         twod_data[4].number,
//         twod_data[5].number,
//         twod_data[6].number,
//         twod_data[7].number,
//         twod_data[8].number,
//         twod_data[9].number
//       ];
//     const labels2 = [
//         lp_data[0].number,
//         lp_data[1].number,
//         lp_data[2].number,
//         lp_data[3].number,
//         lp_data[4].number,
//         lp_data[5].number,
//         lp_data[6].number,
//         lp_data[7].number,
//         lp_data[8].number,
//         lp_data[9].number,
//       ];

//       const data1 = {
//         labels: labels1,
//         datasets: [{
//           label: 'Amount',
//           backgroundColor: '#EB5E28',
//           borderColor: 'rgb(255, 99, 132)',
//           data: [ twod_data[0].sale_amount,  twod_data[1].sale_amount,  twod_data[2].sale_amount,  twod_data[3].sale_amount,  twod_data[4].sale_amount,  twod_data[5].sale_amount,  twod_data[6].sale_amount,  twod_data[7].sale_amount, twod_data[8].sale_amount, twod_data[9].sale_amount]
//         }]
//       };
//       const data2 = {
//         labels: labels2,
//         datasets: [{
//           label: 'Amount',
//           backgroundColor: '#EB5E28',
//           borderColor: 'rgb(255, 99, 132)',
//           data: [ lp_data[0].sale_amount,  lp_data[1].sale_amount,  lp_data[2].sale_amount,  lp_data[3].sale_amount,  lp_data[4].sale_amount,  lp_data[5].sale_amount,  lp_data[6].sale_amount,  lp_data[7].sale_amount, lp_data[8].sale_amount, lp_data[9].sale_amount],
//         }]
//       };

//       const config1 = {
//         type: 'bar',
//         data: data1,
//         options: {}
//       };
//       const config2 = {
//         type: 'bar',
//         data: data2,
//         options: {}
//       };

//       const twodChart = new Chart(
//         document.getElementById('2dchart'),
//         config1
//       );
//       const lonepyineChart = new Chart(
//         document.getElementById('lonepyinechart'),
//         config2
//       );
// });

</script>

@endsection
