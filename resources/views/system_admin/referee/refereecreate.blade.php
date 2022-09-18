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
            <div class="alert alert-success alert-dismissible fade in">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
                <strong>{{ Session::get('success') }}</strong>
            </div>
        @endif

        <!--Create referee start-->

        <div class="create-referee-parent-container">
            <h1>Create Referee</h1>
            <form action="{{ route('refereecreate.store') }}" method="POST" enctype="multipart/form-data" class="create-referee-container">
                @csrf
                <input type="hidden" value="{{$guest->id}}" name="user_id" >

                <div class="create-referee-inputs-parent-container">

                <select name="request_type">
                    <option value="1">Referee</option>
                    <option value="2">Operaton Staff</option>
                    <option value="3">Agent</option>
                </select><br>

                Operation Staff ID :<input type="text" name="operationstaff_code"><br><br>
                Referee ID :<input type="text" name="referee_code"><br><br>

                <div class="create-refree-inputs-btns-container">
                    <button type="submit">Create Referee</button>
                    <button type="button">Cancel</button>
                </div>

                </div>

            </form>
        </div>

        <!--create referee end-->

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
