@extends('system_admin.layouts.app')

@section('title', 'Edit Operation Staff')

@section('content')
    <div>
        <!--Edit Operation-staff-->

        <div class="create-referee-parent-container">
            <h1>{{__('msg.Edit Operation Staff')}}</h1>
            <form action="{{ route('operation-staff.update' , $operation_staff->id) }}" method="POST" enctype="multipart/form-data" class="create-referee-container">
                @csrf
                @method('PUT')
              <div class="form-group">
                <!-- form-group -->
                <label class="label">
                    <i class="fa-solid fa-plus"></i>
                    <span class="title">Add Photo</span>
                    <input type="file" id="imgInp" name="profile_img"/>

                    <p>Profile Image</p>

                    <img src="{{ asset('/image/'.$operation_staff->image) }}" alt="">
                    {{-- <a href=">{{ $referee->image }}</a> --}}
                        {{-- <input type="file" class="form-control form-control-md" id="profile_img" > --}}
                    {{-- <div class="preview_img mt-2"></div> --}}
                </label>
              </div>

              <div class="create-referee-inputs-parent-container">

                <div class="create-referee-inputs-row">
                  <div class="create-referee-name-container">
                    <label for="referee-name">{{__('msg.Name')}}</label>
                    <input type="text" placeholder="Enter Your Name" name="name" id="name" value="{{ $operation_staff->user->name}}" autofocus>
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                  </div>
                  <div class="create-referee-phno-container">
                    <label for="referee-phno">{{__('msg.Phone Number')}}</label>
                    <input type="number" placeholder="Enter Your Phone Number" name="phone" id="phone" value="{{$operation_staff->user->phone}}" autofocus>
                    @error('phone')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                  </div>
                </div>

                <div class="create-refree-inputs-btns-container">
                    <button type="submit">{{__('msg.Save')}}</button>
                    <button type="reset" onclick="javascript:history.back()">{{__('msg.Cancel')}}</button>
                </div>

              </div>

            </form>
        </div>

    </div>

@endsection


@push('script')
    <script>

    </script>
@endpush
