@extends('system_admin.layouts.app')

@section('title', 'Referee Profile')

@section('css')
    <style>
        #main_cash_hitory_table {
            margin: 15px 0px;
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #main_cash_hitory_table td,
        #main_cash_hitory_table th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #main_cash_hitory_table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #main_cash_hitory_table tr:hover {
            background-color: #ddd;
        }

        #main_cash_hitory_table tr {
            text-align: center;
        }

        #main_cash_hitory_table th {

            padding-top: 12px;
            padding-bottom: 12px;

            background-color: #ccc;
            color: #fff;
        }
    </style>

@endsection
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
            <a href="{{ url()->previous() }}">Back</a>
            <h1>Referee Profile</h1>
            <div class="referee-profile-details-parent-container">
                <div class="referee-profile-details-container">
                    <div class="referee-profile-img-container">
                        <img src="{{ asset('/image/' . $referee->image) }}" title="Referee Profile" alt="" />
                    </div>

                    <div class="referee-profile-attributes-container">
                        <div class="referee-profile-attribute">
                            <h3>{{__('msg.referee')}} {{__('msg.AgID')}}</h3>
                            <p>{{$referee->referee_code}}</p>
                        </div>
                        <div class="referee-profile-attribute">
                            <h3>{{__('msg.referee')}} {{__('msg.Name')}}</h3>
                            <p>{{$referee->user->name}}</p>
                        </div>
                        <div class="referee-profile-attribute">
                            <h3>{{__('msg.Phone Number')}}</h3>
                            <p>{{$referee->user->phone}}</p>
                        </div>
                        <div class="referee-profile-attribute">
                            <h3>{{__('msg.Total Sale Amount')}}</h3>
                            @if ($sum== null || $sum==0)
                                <p>0 {{__('ks')}}</p>
                                @else
                                <p>{{$sum}} {{__('msg.ks')}}</p>
                            @endif

                        </div>
                    </div>
                </div>
                <div class="referee-profile-chart-container">
                    <p class="chart-label">{{__('msg.Total Sale Amount Of Agents')}}</p>
                    @if(count($agentsaleamounts) !=5 || count($agentsaleamounts) !=null)
                        <p style="text-align: center;">{{__('msg.Your total sale amount of agent is under 5 transactions. So you can not view the chart')}}</p>
                    @else
                        <canvas id="agchart"></canvas>
                    @endif
                </div>
            </div>

            <!--main content end-->
        </div>

        <h1 style="margin-top: 20px;">Adding Referee MainCash History</h1>
        <table id="main_cash_hitory_table">
            <tr>
                <th>ID</th>
                <th>Main Cash</th>
                <th>DateTime</th>
            </tr>
            @php
                $i = 1;
            @endphp
            @foreach ($referee_maincash_hitories as $main_cash_history)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $main_cash_history->main_cash }}</td>
                    <td>{{ $main_cash_history->updated_at }}</td>
                </tr>
            @endforeach
        </table>

        <h1 style="margin-top: 20px;">CashIn to Agent History</h1>
        <table id="agent_cash_history_table">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>CashIn</th>
            </tr>
            @php
                $i = 1;
            @endphp
            @foreach ($referee_maincash_hitories as $main_cash_history)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $main_cash_history->main_cash }}</td>
                    <td>{{ $main_cash_history->updated_at }}</td>
                </tr>
            @endforeach
        </table>
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

                    var agentdata = @json($agentsaleamounts);
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
                            data: [agentdata[0].maincash, agentdata[1].maincash, agentdata[2].maincash,
                                agentdata[3].maincash
                            ]

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
