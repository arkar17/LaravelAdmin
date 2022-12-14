@extends('system_admin.layouts.app')

@section('title', 'Referee Profile')

@section('css')
    <style>
        #main_cash_hitory_table,
        #cashin_hitory_table,#payment_hitory_table, #cashout_hitory_table {
            margin: 15px 0px;
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;

            display: block;
            /* height: 200px; */
            /* overflow-y: scroll; */
            /* height: 100px !important;
                    overflow-y: hidden; */
        }

        #main_cash_hitory_table td,
        #main_cash_hitory_table th,
        #cashin_hitory_table td,
        #cashin_hitory_table th,
        #payment_hitory_table td, #payment_hitory_table th,
        #cashout_hitory_table td, #cashout_hitory_table th{
            border: 1px solid #ddd;
            padding: 8px;
        }

        #main_cash_hitory_table tr:nth-child(even),
        #cashin_hitory_table tr:nth-child(even),
        #payment_hitory_table tr:nth-child(even),
        #cashout_hitory_table tr:nth-child(even){
            background-color: #f2f2f2;
        }

        #main_cash_hitory_table tr:hover,
        #cashin_hitory_table tr:hover,
        #payment_hitory_table tr:hover,
        #cashout_hitory_table tr:hover {
            background-color: #ddd;
        }

        #main_cash_hitory_table tr,
        #cashin_hitory_table tr, #payment_hitory_table tr,
        #cashout_hitory_table tr {
            text-align: center;
        }

        #main_cash_hitory_table th,
        #cashin_hitory_table th, #payment_hitory_table th, #cashout_hitory_table th {

            padding-top: 12px;
            padding-bottom: 12px;

            background-color: #3C3C3C;
            color: #fff;
        }

        .backBtn {
            color: white;
            background-color: #3C3C3C;
            padding: 7px;
            width: 60px;
            border-radius: 5px;
            text-align: center;
            border: 1px solid #3C3C3C;
            margin-bottom: 10px;

        }

        .backBtn:hover {
            background-color: #fff;
            color: #3C3C3C;
            border: 1px solid #3C3C3C;
        }
    </style>

@endsection
@section('content')
    <div>
        @if (Session::has('success'))
            <div class="alert alert-success alert-dismissible fade in">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">??</span></button>
                <strong>{{ Session::get('success') }}</strong>
            </div>
        @endif
        <!--main content start-->
        <!--referee profile start-->
        <div class="referee-profile-parent-container">
            <a href="{{ url()->previous() }}" class="backBtn"><i class="fa-solid fa-left-long fa-2xl"></i></a>
            <h1>{{__('msg.Referee Profile')}}</h1>
            <div class="referee-profile-details-parent-container">
                <div class="referee-profile-details-container">
                    <div class="referee-profile-img-container">
                        <img src="{{ asset('/image/' . $referee->image) }}" title="Referee Profile" alt="" />
                    </div>

                    <div class="referee-profile-attributes-container">
                        <div class="referee-profile-attribute">
                            <h3>{{ __('msg.referee') }} {{ __('msg.AgID') }}</h3>
                            <p>{{ $referee->referee_code }}</p>
                        </div>
                        <div class="referee-profile-attribute">
                            <h3>{{ __('msg.referee') }} {{ __('msg.Name') }}</h3>
                            <p>{{ $referee->user->name }}</p>
                        </div>
                        <div class="referee-profile-attribute">
                            <h3>{{ __('msg.Phone Number') }}</h3>
                            <p>{{ $referee->user->phone }}</p>
                        </div>
                        <div class="referee-profile-attribute">
                            <h3>{{ __('msg.Total Sale Amount') }}</h3>
                            @if ($sum == null || $sum == 0)
                                <p>0 {{ __('ks') }}</p>
                            @else
                                <p>{{ $sum }} {{ __('msg.ks') }}</p>
                            @endif

                        </div>
                    </div>
                </div>
                <div class="referee-profile-chart-container">
                    <p class="chart-label">{{ __('msg.Total Sale Amount Of Agents') }}</p>
                    @if (count($agentsaleamounts) != 5 || count($agentsaleamounts) != null)
                        <p style="text-align: center;">
                            {{ __('msg.Your total sale amount of agent is under 5 transactions. So you can not view the chart') }}
                        </p>
                    @else
                        <canvas id="agchart"></canvas>
                    @endif
                </div>
            </div>

            <!--main content end-->
        </div>

        <h1 style="margin-top: 20px;">{{__('msg.Adding Referee MainCash History')}}</h1>
        <table id="main_cash_hitory_table">
            <tr>
                <th>{{__('msg.AgID')}}</th>
                <th>{{__('msg.Main Cash')}}</th>
                <th>{{__('msg.DateTime')}}</th>
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

        <h1 style="margin-top: 20px;">{{__('msg.CashIn to Agent History')}}</h1>
        <table id="cashin_hitory_table">
            <tr>
                <th>{{__('msg.AgID')}}</th>
                <th>{{__('msg.Name')}}</th>
                <th>{{__('msg.CashIn')}}</th>
                <th>{{__('msg.DateTime')}}</th>
            </tr>
            @php
                $i = 1;
            @endphp

            @foreach ($agent_cash_histories as $agent_cash_history)
                @if ($agent_cash_history->agent_cash != 0)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $agent_cash_history->agent->user->name }}</td>
                        <td>{{ $agent_cash_history->agent_cash }}</td>
                        <td>{{ $agent_cash_history->updated_at }}</td>
                    </tr>
                @endif
            @endforeach
        </table>

        <h1 style="margin-top: 20px;">{{__('msg.Payment History')}}</h1>
        <table id="payment_hitory_table">
            <tr>
                <th>{{__('msg.AgID')}}</th>
                <th>{{__('msg.Name')}}</th>
                <th>{{__('msg.Paymenthis')}}</th>
                <th>{{__('msg.DateTime')}}</th>
            </tr>
            @php
                $i = 1;
            @endphp
            @foreach ($agent_cash_histories as $agent_cash_history)
                @if ($agent_cash_history->agent_payment != 0)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $agent_cash_history->agent->user->name }}</td>
                        <td>{{ $agent_cash_history->agent_payment }}</td>
                        <td>{{ $agent_cash_history->updated_at }}</td>
                    </tr>
                @endif
            @endforeach

        </table>


        <h1 style="margin-top: 20px;">{{__('msg.CashOut History')}}</h1>
        <table id="cashout_hitory_table">
            <tr>
                <th>{{__('msg.AgID')}}</th>
                <th>{{__('msg.Name')}}</th>
                <th>{{__('msg.Withdraw Amount')}}</th>
                <th>{{__('msg.DateTime')}}</th>
            </tr>
            @php
                $i = 1;
            @endphp

            @foreach ($agent_cash_histories as $agent_cash_history)
                @if ($agent_cash_history->agent_withdraw != 0)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $agent_cash_history->agent->user->name }}</td>
                        <td>{{ $agent_cash_history->agent_withdraw }}</td>
                        <td>{{ $agent_cash_history->updated_at }}</td>
                    </tr>
                @endif
            @endforeach
        </table>
    @endsection

    @push('script')

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
                    var main_cash_hitory_table = document.querySelector("#main_cash_hitory_table");
                    var cashin_hitory_table = document.querySelector("#cashin_hitory_table");
                    var payment_hitory_table = document.querySelector("#payment_hitory_table");
                    var cashout_hitory_table = document.querySelector("#cashout_hitory_table");




                    if (main_cash_hitory_table.offsetHeight > 400) {
                        main_cash_hitory_table.style.height = "400px";
                        main_cash_hitory_table.style.overflowY = "scroll";
                    }

                    if (cashin_hitory_table.offsetHeight > 400) {
                        cashin_hitory_table.style.height = "400px";
                        cashin_hitory_table.style.overflowY = "scroll";
                    }
                    if (payment_hitory_table.offsetHeight > 400) {
                        payment_hitory_table.style.height = "400px";
                        payment_hitory_table.style.overflowY = "scroll";
                    }
                    if (cashout_hitory_table.offsetHeight > 400) {
                        cashout_hitory_table.style.height = "400px";
                        cashout_hitory_table.style.overflowY = "scroll";
                    }

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

    @endpush
