@extends('system_admin.layouts.app')

@section('title', 'Create Referee')

@section('content')
    <div>
        <section class="box">
            <header class="panel_header">
                <h2 class="title pull-left"> <i class="fa-solid fa-shield-halved"></i> &nbsp; Create Referee</h2>
            </header>
            <div class="content-body">
                 <h1>Create Referee</h1>
            <form action="{{ route('referee.store') }}" method="POST" enctype="multipart/form-data" class="create-referee-container">
                @csrf
                <input type="hidden" value="{{$rfid}}" name="rfid">
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
                    <input type="text" id="name" name="name" placeholder="Enter Your Name"/>
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                    </div>
                    <div class="create-referee-phno-container">
                    <label for="referee-phno">Phone Number</label>
                    <input type="text" id="phone" name="phone" placeholder="Enter Your Phone Number"/>
                    @error('phone')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                    </div>
                </div>

                <div class="create-referee-inputs-row">
                    <div class="create-referee-pw-container">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter Password"/>
                    </div>
                    <div class="create-referee-confirmpw-container">
                    <label for="referee-confirmpw">Confirm Password</label>
                    <input type="password" id="referee-confirmpw" name="confirmpasword" placeholder="Re-enter Password"/>
                    </div>
                </div>

                <div class="create-referee-inputs-row">
                    <div class="create-referee-name-container">
                        <div class="create-referee-pw-container">
                            <label for="referee-pw">Operation Staff ID</label>
                            <input list="opid" name="parent_id" placeholder="Enter Operation Staff ID" id="operationstaff_id">
                            <datalist id="opid" name="parent_id">
                                @foreach ($referees as $referee)
                                <option>{{$referee->operationstaff_id}}</option>
                                @endforeach
                            </datalist>
                        </div>
                    </div>
                </div>

                <div class="create-refree-inputs-btns-container">
                    <button type="submit">Create Referee</button>
                    <button type="reset">Cancel</button>
                </div>

                </div>

            </form>
            </div>
        </section>
    </div>

@endsection


@push('script')
    <script>

    </script>
@endpush
