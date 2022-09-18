@extends('system_admin.layouts.app')


@section('content')
<div class="main-content-parent-container">
    <!--dashboard start-->
    <div class="dashboard-gradient-boxes-container">
        <div class="dashboard-gradient-registeration-container">
            <iconify-icon icon="lucide:user-plus" class="dashboard-registeration-icon"></iconify-icon>
            <p class="dashboard-gradient-label">Number of registerations</p>
            <p class="dashboard-gradient-stat">{{ count($users) }}</p>
        </div>
        <div class="dashboard-gradient-traffic-container">
            <iconify-icon icon="majesticons:users-line" class="dashboard-referee-icon"></iconify-icon>
            <p class="dashboard-gradient-label">Number of agents</p>
            <p class="dashboard-gradient-stat">{{count($agents)}}</p>
        </div>
        <div class="dashboard-gradient-referee-container">
            <iconify-icon icon="majesticons:users-line" class="dashboard-referee-icon"></iconify-icon>
            <p class="dashboard-gradient-label">Total No of Referees</p>
            <p class="dashboard-gradient-stat">{{ count($referees) }}</p>
        </div>
        <div class="dashboard-gradient-sale-container">
            <iconify-icon icon="bi:currency-dollar" class="dashboard-sale-icon"></iconify-icon>
            <p class="dashboard-gradient-label">Total Sale Amount</p>
            <p class="dashboard-gradient-stat">{{$sum}}</p>
        </div>
    </div>

    <div class="dashboard-bar-charts-parent-container">
      <div class="dashboard-2d-chart-container">
        <p class="chart-label">Most Bet 2D Number</p>
        <canvas id="2dchart"></canvas>
      </div>

      <div class="dashboard-lonepyine-container">
        <p class="chart-label">Most Bet Lone Pyine Number</p>
        <canvas id="lonepyinechart"></canvas>
      </div>
    </div>
    <div class="dashboard-lonepyine-container">
        <p class="chart-label">Total Sale Amount Of Referee</p>
        <canvas id="refereechart"></canvas>
      </div>
</div>
@endsection


@section('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>

    $(document).ready(function(){
        var twod_data = @json($twod_salelists);
        console.log(twod_data);

        var lp_data =  @json($lp_salelists);
        console.log(lp_data);

        var refereedata= @json($refereesaleamounts);
        console.log(refereedata);

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

      const labels3 = [
        refereedata[0].maincash,
        refereedata[1].maincash,
        refereedata[2].maincash,
        refereedata[3].maincash,
        refereedata[4].maincash,
        refereedata[5].maincash,
        refereedata[6].maincash,
        refereedata[7].maincash,
        refereedata[8].maincash,
        refereedata[9].maincash
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

      const data3 = {
        labels: labels3,
        datasets: [{
          label: 'Amount',
          backgroundColor: '#EB5E28',
          borderColor: 'rgb(255, 99, 132)',
          data: [ refereedata[0].maincash,  refereedata[1].maincash,  refereedata[2].maincash,  refereedata[3].maincash,  refereedata[4].maincash,  refereedata[5].maincash,  refereedata[6].maincash,  refereedata[7].maincash, refereedata[8].maincash, refereedata[9].maincash]

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

    const config3 = {
    type: 'line',
    data: data3,
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
      const refereeChart = new Chart(
        document.getElementById('refereechart'),
        config3
      );

})

</script>

@endsection
