@extends('system_admin.layouts.app')

@section('title', 'Edit Referee')

@section('content')
    <div>
        <!--Edit referee start-->
        <div class="create-referee-parent-container">
            <h1>Edit Referee</h1>
            <form action="{{ route('referee.update' , $referee->id) }}" method="POST" enctype="multipart/form-data" class="create-referee-container">
                @csrf
                @method('PUT')
                <div class="form-group">
                <!-- form-group -->
                <label class="label">
                    <i class="fa-solid fa-plus"></i>
                    <span class="title">Add Photo</span>
                    <input type="file" id="imgInp" name="profile_img"/>

                    <p>Profile Image</p>

                    <img src="{{ asset('/image/'. $referee->image) }}" alt="">
                    {{-- <a href=">{{ $referee->image }}</a> --}}
                        {{-- <input type="file" class="form-control form-control-md" id="profile_img" > --}}
                    {{-- <div class="preview_img mt-2"></div> --}}
                </label>
                </div>

                <div class="create-referee-inputs-parent-container">
                <div class="create-referee-inputs-row">
                    <div class="create-referee-name-container">
                    <label for="referee-name">Name</label>
                    <input type="text" placeholder="Enter Your Name" name="name" id="name" value="{{ old('name', $referee->user->name) }}" autofocus>

                    </div>
                    <div class="create-referee-phno-container">
                    <label for="referee-phno">Phone Number</label>
                    <input type="number" placeholder="Enter Your Phone Number" name="phone" id="phone" value="{{ old('phone', $referee->user->phone) }}">
                    </div>
                </div>

                <div class="create-referee-inputs-row">
                    <div class="create-referee-pw-container">
                    <label for="password">Password</label>
                    <input type="password" placeholder="Enter Password" name="password" id="password"  value="{{ old('password', $referee->user->password) }}">
                    </div>
                    <div class="create-referee-confirmpw-container">
                    <label for="referee-confirmpw">Confirm Password</label>
                    <input type="password" id="referee-confirmpw" name="confirmpasword" placeholder="Re-enter Password"/>
                    </div>

                </div>

                <div class="create-referee-inputs-row">
                    <div class="create-referee-opstaff-container">
                        <label for="referee-pw">Operation Staff</label>
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
                    <div class="create-referee-role-container">
                        <label>Role</label>
                        <select name="role_id">
                            @foreach ($roles as $role)
                            <option value="{{ $role->id }}" {{$referee->role_id == $role->id  ? 'selected' : ''}}>{{ $role->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="create-referee-inputs-row">
                    <div class="create-referee-date-container">
                        <label for="avaliable_date">Avaliable Date:</label>
                        <input type="datetime-local" id="avaliable_date" name="avaliable_date">
                    </div>
                    <div class="create-referee-active-container">
                        <div>
                            <label for="active">Active</label>
                            <input id="active" type="radio" name="active_status" value="1" {{ $referee->active_status == 1 ? 'checked' : ''}} >
                        </div>
                        <div>
                            <label for="inactive">Inactive</label>
                            <input id="inactive" type="radio" name="active_status" value="0" {{ $referee->active_status == 0 ? 'checked' : ''}}>
                        </div>

                    </div>
                </div>

                <div class="create-refree-inputs-btns-container">
                    <button type="submit">Edit</button>
                    <button type="button">Cancel</button>
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
