@extends('system_admin.layouts.app')

@section('title', 'Edit Referee')

@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <div>
        <!--Edit referee start-->
        <div class="create-referee-parent-container">
            <h1>{{__('msg.Edit')}} {{__('msg.referee')}}</h1>
            <form action="{{ route('referee.update' , $referee->id) }}" method="POST" enctype="multipart/form-data" class="create-referee-container">
                @csrf
                @method('PUT')
                <div class="form-group">
                <!-- form-group -->
                <label class="label">
                    <i class="fa-solid fa-plus"></i>
                    <span class="title">Add Photo</span>
                    <input type="file" id="imgInp" name="profile_img"/>

                    <p>{{__('msg.Profile Image')}}</p>

                    <img src="{{ asset('/image/'.$referee->image) }}" alt="">
                    {{-- <a href=">{{ $referee->image }}</a> --}}
                        {{-- <input type="file" class="form-control form-control-md" id="profile_img" > --}}
                    {{-- <div class="preview_img mt-2"></div> --}}
                </label>
                </div>

                <div class="create-referee-inputs-parent-container">
                <div class="create-referee-inputs-row">
                    <div class="create-referee-name-container">
                    <label for="referee-name">{{__('msg.Name')}}</label>
                    <input type="text" placeholder="Enter Your Name" name="name" id="name" value="{{ old('name', $referee->user->name) }}" autofocus>
                    </div>
                    <div class="create-referee-phno-container">
                    <label for="referee-phno">{{__('msg.Phone Number')}}</label>
                    <input type="number" placeholder="Enter Your Phone Number" name="phone" id="phone" value="{{ old('phone', $referee->user->phone) }}">
                    </div>
                </div>

                <div class="create-referee-inputs-row">
                    <div class="create-referee-opstaff-container">
                        <label for="referee-pw">{{__('msg.operationstaff')}}</label>
                        {{-- <input type="text" value="{{$referee->operationstaff->operationstaff_code}}" name="operationstaff_id" disabled> --}}
                        <input list="opid" value="{{$referee->operationstaff->operationstaff_code}}" name="operationstaff_id" placeholder="Enter Operation Staff ID" id="operationstaff_id">
                        <datalist id="opid" name="operationstaff_id">
                            @foreach ($operationstaffs as $operationstaff)
                            <option data-id="{{$operationstaff->id }}" value ="{{$operationstaff->operationstaff_code}}"></option>
                            @endforeach
                        </datalist>
                    </div>

                            {{-- <select name="operationstaff_id">
                                <option value="option_select" disabled selected>Shoppings</option>
                                @foreach($operationstaffs as $operationstaff)
                                    <option value="{{ $operationstaff->id }}" {{$referee->operationstaff_id == $operationstaff->id  ? 'selected' : ''}}>{{ $operationstaff->operationstaff_code}}</option>
                                @endforeach
                            </select> --}}
                        {{-- </div> --}}


                    {{-- </div> --}}
                    {{-- <div class="create-referee-role-container">
                        <label>{{__('msg.role')}}</label>
                        <select name="role_id">
                            @foreach ($roles as $role)
                            <option value="{{ $role->id }}" {{$referee->role_id == $role->id  ? 'selected' : ''}}>{{ $role->name}}</option>
                            @endforeach
                        </select>
                    </div> --}}
                </div>
                <input type="hidden" name="image" value="{{$referee->image}}">
                <div class="create-referee-inputs-row">
                    <div class="create-referee-date-container">
                        <label for="avaliable_date">{{__('msg.Avaliable Date')}}</label>
                        <input type="datetime-local" id="avaliable_date" name="avaliable_date" value="{{$referee->avaliable_date}}">
                    </div>
                    <div class="create-referee-active-container">
                        <div>
                            <label for="active">{{__('msg.Active')}}</label>
                            <input id="active" type="radio" name="active_status" value="1" {{ $referee->active_status == 1 ? 'checked' : ''}} >
                        </div>
                        <div>
                            <label for="inactive">{{__('msg.Inactive')}}</label>
                            <input id="inactive" type="radio" name="active_status" value="0" {{ $referee->active_status == 0 ? 'checked' : ''}}>
                        </div>

                    </div>
                </div>

                <div class="create-refree-inputs-btns-container">
                    <button type="submit">{{__('msg.Save')}}</button>
                    <button type="reset" onclick="javascript:history.back()">{{__('msg.Cancel')}}</button>
                </div>
                @if (Session::has('success'))
                <div id="hide">
                    <h4 class="main-cash-alert"> {{ Session::get('success') }} <span class="closeBtn">X</span> </h4>
                </div>
                @endif

                </div>

            </form>
        </div>

    </div>

@endsection


@push('script')
    <script>

    </script>
@endpush
