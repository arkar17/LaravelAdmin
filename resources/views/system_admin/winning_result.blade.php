@extends('system_admin.layouts.app')



@section('title', 'Referees')



@section('custom_css')

    <style>

        .client_img {

            width: 60px;

            height: 60px;

            border: 2px solid #ddd;

            border-radius: 10px !important;

            padding: 3px;

        }



    </style>

@endsection



@section('content')

    <div>

        @if (Session::has('success'))
        <div id="hide">
            <h4 class="main-cash-alert"> {{ Session::get('success') }} <span class="closeBtn">X</span> </h4>
        </div>
        @endif

        <div class="section-line"></div>



        <!--referee list start-->

        <div class="referee-list-parent-container">

            <h1>{{__('msg.Winning Result')}}</h1>

            <div class="referee-list-container">

                <form action="{{ route('add_winningstatus') }}" method="POST" enctype="multipart/form-data" class="winningresult-form">

                    @csrf

                    <select class="winningresult-select" name="type" required>

                        <option value="">{{__('msg.Select Type')}}</option>

                        <option value="2d">2D</option>

                        <option value="3d">3D</option>

                    </select>

                    <input type="number" name="number" required>

                    <button type="submit">{{__('msg.Submit')}}</button>

                </form>

            </div>



        </div>

    </div>



    <div>

        @if(count($twodnumbers)==0)

        <div></div>

        @else

        <h3 class="winners-header">Winning 2D</h3>

        <table class="winning-table-parent-container">

            <tr class="table-lables" style="background-color: none">

                <th>id</th>

                <th>Agent Name</th>

                <th>Number</th>

                <th>Customer Name</th>

                <th>Customer Phone</th>

                <th>Round</th>

                <th>Date Time</th>

            </tr>


            <tbody class="table-body-container">

                @foreach ($twodnumbers as $twodnumber)

                <tr class="table-row">

                    <td>2D-{{$twodnumber->id}}</td>

                    <td>{{$twodnumber->name}}</td>

                    <td>{{$twodnumber->number}}</td>

                    <td>{{$twodnumber->customer_name}}</td>

                    <td>{{$twodnumber->customer_phone}}</td>

                    <td>{{$twodnumber->round}}</td>

                    <td>{{$twodnumber->date}}</td>

                </tr>

                @endforeach
            </tbody>
        </table>
        @endif

        @if(count($lonepyinenumbers)==0)

        <div></div>

        @else
        <h3 class="winners-header">Winning Lone Pyine</h3>
        <table class="winning-table-parent-container">
            <tr class="table-lables" style="background-color: none">

                <th>id</th>

                <th>Agent Name</th>

                <th>Number</th>

                <th>Customer Name</th>

                <th>Customer Phone</th>

                <th>Round</th>

                <th>Date Time</th>

            </tr>

            <tbody class="table-body-container">
                @foreach ($lonepyinenumbers as $lonepyinenumber)
                <tr class="table-row">

                    <td>LP-{{$lonepyinenumber->id}}</td>

                    <td>{{$lonepyinenumber->name}}</td>

                    <td>{{$lonepyinenumber->number}}</td>

                    <td>{{$lonepyinenumber->customer_name}}</td>

                    <td>{{$lonepyinenumber->customer_phone}}</td>

                    <td>{{$lonepyinenumber->round}}</td>

                    <td>{{$lonepyinenumber->date}}</td>

                </tr>

                @endforeach
            </tbody>
        </table>
        @endif
            @if (count($threednumbers)==0)

            <div></div>

            @else

            <h3>Winning 3D Number Lists</h3>

            <table class="winning-table-parent-container">

                <tr class="table-lables" style="background-color: none">

                    <th>id</th>

                    <th>Agent Name</th>

                    <th>Number</th>

                    <th>Customer Name</th>

                    <th>Customer Phone</th>

                    <th>Date Time</th>

                </tr>



                @foreach ($threednumbers as $threednumber)
                <tbody class="table-body-container">
                <tr class="table-row">

                    <td>2D-{{$threednumber->id}}</td>

                    <td>{{$threednumber->name}}</td>

                    <td>{{$threednumber->number}}</td>

                    <td>{{$threednumber->customer_name}}</td>

                    <td>{{$threednumber->customer_phone}}</td>

                    <td>{{$threednumber->date}}</td>

                </tr>
                </tbody>

                @endforeach

            </table>

            @endif

    </div>



    <script>

    $('#operationstaff-id').on('click',function() {



        var sel=document.getElementById('operationstaff-id');

        console.log(sel.value);



    });



        </script>

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

                                url: `/referee/${id}`

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

