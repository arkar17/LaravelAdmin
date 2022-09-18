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
            <div class="op-profile-parent-container">
                <h1>Data - Operation Staff Data - Operation Staff Profile</h1>

                <div class="op-profile-filters-container">
                    <input id="op-profile-filter-fromdate" type="date" placeholder="From Date" />
                    <input id="op-profile-filter-todate" type="date" placeholder="To Date" />

                    <button class="op-profile-filter-btn">
                        <iconify-icon icon="ant-design:search-outlined" class="op-data-filter-btn-icon"></iconify-icon>
                        <p>Filter</p>
                    </button>

                </div>
            <div class="op-profile-details-parent-container">
                <div class="op-profile-details-container">
                    <div class="op-profile-img-container">
                        <img src="{{asset('storage/image/'.$operationstaff->image)}}" title="Referee Profile" alt=""/>
                    </div>

                    <div class="op-profile-attributes-container">
                        <div class="op-profile-attribute">
                            <h3>Operation Staff ID</h3>
                            <p>{{$operationstaff->operationstaff_code}}</p>
                        </div>
                        <div class="op-profile-attribute">
                            <h3>Operation Staff Name</h3>
                            <p>{{$operationstaff->user->name}}</p>
                        </div>
                        <div class="op-profile-attribute">
                            <h3>Phone Number</h3>
                            <p>{{$operationstaff->user->phone}}</p>
                        </div>
                        <div class="op-profile-attribute">
                            <h3>Total Sale Amount</h3>
                            <p>1000000</p>
                        </div>
                    </div>
                </div>
                <div class="op-profile-chart-container">

                </div>
            </div>

            <div class="section-line">

            </div>

            <div class="op-profile-referee-list-parent-container">
                <div class="op-profile-referee-list-header">
                    <h1>{{$operationstaff->operationstaff_code}} 's Referee List</h1>
                    <div class="op-profile-referee-list-filter">
                        <iconify-icon icon="ant-design:search-outlined" class="op-profile-referee-list-icon"></iconify-icon>
                        <input list="agents" name="myBrowser" placeholder="Search By Name"/>
                        <datalist id="agents">
                            <option value="Agent 01">
                            <option value="Agent 02">
                            <option value="Agent 03">
                        </datalist>
                    </div>
                </div>

                <div class="op-profile-referee-list-container">
                    <div class="op-profile-referee-list-labels-container">
                        <h2>Referee ID</h2>
                        <h2>Name</h2>
                        <h2>Phone No.</h2>
                    </div>

                    <div class="op-profile-referee-list-rows-container">
                        @foreach ($referees as $referee)
                        <div class="op-profile-referee-list-row">
                            <p>{{$referee->id}}</p>
                            <p>{{$referee->user->name}}</p>
                            <p>{{$referee->user->phone}}</p>
                            <a href="{{route('refreeprofile',$referee->id)}}">
                                <iconify-icon icon="ant-design:exclamation-circle-outlined" class="op-profile-referee-list-btn"></iconify-icon>
                                <p>View Details</p>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        <!--main content end-->
    </div>
@endsection

@push('script')
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
        })
    </script>
@endpush
