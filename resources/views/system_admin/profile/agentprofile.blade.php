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
                <h1>Data - Agent Data - Agent Profile</h1>

                <div class="agent-profile-filters-container">
                    <input id="agent-profile-filter-fromdate" type="date" placeholder="From Date" />
                    <input id="agent-profile-filter-todate" type="date" placeholder="To Date" />

                    <button class="agent-profile-filter-btn">
                        <iconify-icon icon="ant-design:search-outlined" class="agent-data-filter-btn-icon"></iconify-icon>
                        <p>Filter</p>
                    </button>

                </div>
            <div class="agent-profile-details-parent-container">
                <div class="agent-profile-details-container">
                    <div class="agent-profile-img-container">
                        <img src="{{asset('/image/'.$agent->image)}}" title="Agent Profile" alt=""/>
                    </div>

                    <div class="agent-profile-attributes-container">
                        <div class="agent-profile-attribute">
                            <h3>ID</h3>
                            <p>AG{{$agent->id}}</p>
                        </div>
                        <div class="agent-profile-attribute">
                            <h3>Agent Name</h3>
                            <p>{{$agent->name}}</p>
                        </div>
                        <div class="agent-profile-attribute">
                            <h3>Phone Number</h3>
                            <p>{{$agent->phone}}</p>
                        </div>
                        <div class="agent-profile-attribute">
                            <h3>Referee Code</h3>
                            <p>{{$agent->referee_code}}</p>
                        </div>
                        <div class="agent-profile-attribute">
                            <h3>Total Sale Amount</h3>
                            <p>{{$sum}}</p>
                        </div>
                    </div>
                </div>
                <div class="agent-profile-chart-container">
                    <p class="chart-label">Total Sale Amount Of Customers</p>
                    <canvas id="cuschart"></canvas>
                </div>
            </div>
            <div class="agent-profile-customer-list-parent-container">
                <div class="agent-profile-customer-list-header">
                    <h1>{{$agent->name}} 's Customer List</h1>

                    <div class="export-btns-container">
                        <a href="{{route('customer.export_excel',$agent->id)}}">Export excel </a>

                        <a href="{{route('customer.export_pdf',$agent->id)}}">Export pdf</a>
                    </div>


                    <div class="agent-profile-customer-list-filter">
                        <iconify-icon icon="ant-design:search-outlined" class="agent-profile-customer-list-icon"></iconify-icon>
                        <input list="agents" name="myBrowser" placeholder="Search By Name"/>
                        <datalist id="agents">
                            <option value="Agent 01">
                            <option value="Agent 02">
                            <option value="Agent 03">
                        </datalist>
                    </div>
                </div>

                <div class="agent-profile-customer-list-container">
                    <div class="agent-profile-customer-list-labels-container">
                        <h2>No</h2>
                        <h2>Name</h2>
                        <h2>Phone No.</h2>
                        <h2>Sale Amount</h2>
                    </div>
                    <?php
                    $i=1;
                    ?>
                    <div class="agent-profile-customer-list-rows-container">
                        @foreach ($results as $result)
                        <div class="agent-profile-customer-list-row">
                            <p>{{$i++}}</p>
                            <p>{{$result['customer_name']}}</p>
                            <p>{{$result['customer_phone']}}</p>
                            <p>{{$result['Amount']}}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
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
            });
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
@endpush
