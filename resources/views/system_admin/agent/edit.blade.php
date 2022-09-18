@extends('system_admin.layouts.app')

@section('title', 'Create Agent')

@section('content')
    <div>
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <p class="text-danger">{{ $error }}</p>
            @endforeach
        @endif
        <section class="box">
            <header class="panel_header">
                <h2 class="title pull-left"> <i class="fa-solid fa-shield-halved"></i> &nbsp; Create Agent</h2>
            </header>
            <div class="content-body">
                <form action="{{ route('agent.update', $agent->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-8 col-sm-9 col-xs-10">
                            <div class="form-group @error('name') has-error @enderror">
                                <label class="form-label" for="name">Name</label>
                                <div class="">
                                    <input type="text" class="form-control" name="name"
                                        value="{{ old('name', $agent->name) }}" id="name" autofocus>
                                    @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group @error('phone') has-error @enderror">
                                <label class="form-label" for="phone">Phone</label>
                                <div class="">
                                    <input type="number" class="form-control" name="phone"
                                        value="{{ old('phone', $agent->phone) }}" id="phone">
                                    @error('phone')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group @error('coin_amount') has-error @enderror">
                                <label for="coin_amount fs" class="form-label">Coin Amount</label>
                                <input type="number" class="form-control form-control-md"
                                    value="{{ old('coin_amount', $agent->coin_amount) }}" id="coin_amount"
                                    name="coin_amount">
                                @error('coin_amount')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group @error('commision') has-error @enderror">
                                <label for="commision fs" class="form-label">Commision</label>
                                <input type="number" class="form-control form-control-md" value="{{old('commision', $agent->commision)}}" id="commision" name="commision">
                                @error('commision')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group @error('referee_id') has-error @enderror">
                                <label for="referee_id fs" class="form-label">Referee ID</label>
                                <input type="text" class="form-control form-control-md" id="referee_id"
                                    name="referee_id" value="{{old('referee_id', $agent->referee_id)}}">
                                @error('referee_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group @error('referee_id') has-error @enderror">
                                <label for="operationstaff_id fs" class="form-label">OperationStaff ID</label>
                                <input type="text" class="form-control form-control-md" id="operationstaff_id"
                                    name="operationstaff_id" value="{{old('operationstaff_id', $agent->operationstaff_id)}}">
                                @error('operationstaff_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group @error('profile_img') has-error @enderror">
                                <label for="profile_img fs" class="form-label">Profile Image</label> <br>
                                <a href="{{ asset('storage/agent/'. $agent->image) }}">{{ $agent->image }}</a>
                                <input type="file" class="form-control form-control-md" id="profile_img"
                                    name="profile_img">
                                @error('profile_img')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                                <div class="preview_img mt-2"></div>
                            </div>


                            <div class="form-group @error('password') has-error @enderror">
                                <label for="form-label" id="password">Password</label>
                                <input type="password" class="form-control form-conrol-md" name="password" id="password">

                                @error('password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="pull-right">
                                <button type="reset" class="btn btn-secondary">Cancel</button>
                                <button type="submit" class="btn btn-info">Update</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </section>
    </div>

@endsection


@push('script')
    <script>
        $(document).ready(function() {
            $('.select2').select2();

            $('#profile_img').on('change', function() {
                let file_length = document.getElementById('profile_img').files.length;
                $('.preview_img').html("");
                for (let i = 0; i < file_length; i++) {
                    $('.preview_img').append(
                        `<img src="${URL.createObjectURL(event.target.files[i])}" class="" width="100" />`
                    );
                }
            })
        })
    </script>
@endpush
