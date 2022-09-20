@extends('RefereeManagement.layout.app')

@section('title', 'Referee Profile')

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
                <h1>Referee Profile</h1>
            <div class="referee-profile-details-parent-container">
                <div class="referee-profile-details-container">
                    <div class="referee-profile-img-container">
                        <img src="{{asset('/image/'.$referee->image)}}" title="Referee Profile" alt=""/>
                    </div>

                    <div class="referee-profile-attributes-container">
                        <div class="referee-profile-attribute">
                            <h3>Referee ID</h3>
                            <p>{{$referee->referee_code}}</p>
                        </div>
                        <div class="referee-profile-attribute">
                            <h3>Referee Name</h3>
                            <p>{{$referee->user->name}}</p>
                        </div>
                        <div class="referee-profile-attribute">
                            <h3>Phone Number</h3>
                            <p>{{$referee->user->phone}}</p>
                        </div>
                        <div class="referee-profile-attribute">
                            <h3>Total Sale Amount</h3>
                            <p>{{$sum}}</p>

                        </div>
                    </div>
                </div>
                <div class="referee-profile-chart-container">
                    <p class="chart-label">Total Sale Amount Of Agents</p>
                    <canvas id="agchart"></canvas>
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
