@extends('system_admin.layouts.app')

@section('title', 'Operation Staff')

@section('custom_css')
    <style>
        .client_img {
            width: 60px;
            height: 60px;
            border: 2px solid #ddd;
            border-radius: 10px !important;
            padding: 3px;
            object-fit: content;
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

         <!--Create referee start-->
        {{--
         <div class="create-referee-parent-container">
            <h1>Create Operation Staff</h1>
            <form action="{{ route('operation-staff.store') }}" method="POST" enctype="multipart/form-data" class="create-referee-container">
                @csrf
              <div class="form-group">
                <!-- form-group -->
                <label class="label">
                  <i class="fa-solid fa-plus"></i>
                  <span class="title">Add Photo</span>
                  <input type="file" id="imgInp" name="profile_img"/>
                </label>
              </div>

              <div class="create-referee-inputs-parent-container">

                <div class="create-referee-inputs-row">
                  <div class="create-referee-name-container">
                    <label for="referee-name">Name</label>
                    <input type="text" id="referee-name" name="name" placeholder="Enter Your Name"/>
                  </div>
                  <div class="create-referee-phno-container">
                    <label for="referee-phno">Phone Number</label>
                    <input type="text" id="referee-phno" name="phone" placeholder="Enter Your Phone Number"/>
                  </div>
                </div>

                <div class="create-referee-inputs-row">
                  <div class="create-referee-pw-container">
                    <label for="referee-pw">Password</label>
                    <input type="password" id="referee-pw" name="password" placeholder="Enter Password"/>
                  </div>
                  <div class="create-referee-confirmpw-container">
                    <label for="referee-confirmpw">Confirm Password</label>
                    <input type="password" id="referee-confirmpw" name="confirmpassword" placeholder="Re-enter Password"/>
                  </div>
                </div>

                <div class="create-refree-inputs-btns-container">
                  <button type="submit">Create Operation Staff</button>
                  <button type="button">Cancel</button>
                </div>

              </div>

            </form>
        </div> --}}

        <!--create referee end-->

        <div class="section-line"></div>

        <!--referee list start-->
        <div class="op-list-parent-container">
          <h1>{{__('msg.Operation-Staff List')}}</h1>
          <table class="op-list-container">
            <thead>
                <tr class="op-list-labels-container">
                <th>{{__('msg.Code')}}</th>
                <th>{{__('msg.Name')}}</th>
                <th>{{__('msg.Phone Number')}}</th>
                {{-- <th>Image</th> --}}
                <th>{{__('msg.Action')}}</th>

                </tr>
            </thead>
            <tbody class="op-list-rows-container">
                @foreach ($operation_staffs as $operation_staff)
                <tr class="op-list-row">
                    <td>{{$operation_staff->operationstaff_code}}</td>
                    <td>{{$operation_staff->name}}</td>
                    <td>{{$operation_staff->phone}}</td>
                    {{-- <td>{{$operation_staff->image}}</td> --}}
                    <td class="op-list-row-actions-container">
                    <a href="{{route('operationstaffprofile',$operation_staff->id)}}">
                    <iconify-icon icon="ant-design:exclamation-circle-outlined" class="op-list-row-icon"></iconify-icon>
                    </a>
                    <a href="{{route('operation-staff.edit',$operation_staff->id)}}">
                    <i class="fa-regular fa-pen-to-square"></i>
                    </a>
                    {{-- <a href="{{route('operation-staff.destroy',$operation_staff->id)}}">
                    <i class="fa-regular fa-trash-can"></i>
                    </a> --}}
                </td>
                </tr>
                @endforeach
            </tbody>
          </table>

        </div>
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
                                url: `/operation-staff/${id}`
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
