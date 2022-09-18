@extends('system_admin.layouts.app')

@section('title', 'Create Operation Staff')

@section('content')
    <div>
        <section class="box">
            <header class="panel_header">
                <h2 class="title pull-left"> <i class="fa-solid fa-shield-halved"></i> &nbsp; Create Operation Staff</h2>
            </header>
            <div class="content-body">
                <form action="{{ route('operation-staff.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-8 col-sm-9 col-xs-10">
                            <div class="form-group @error('name') has-error @enderror">
                                <label class="form-label" for="name">Name</label>
                                <div class="">
                                    <input type="text" class="form-control" name="name" id="name" autofocus>
                                    @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group @error('phone') has-error @enderror">
                                <label class="form-label" for="phone">Phone</label>
                                <div class="">
                                    <input type="number" class="form-control" name="phone" id="phone">
                                    @error('phone')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>



                            <div class="form-group @error('profile_img') has-error @enderror">
                                <label for="profile_img fs" class="form-label">Profile Image</label>
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
                                <button type="submit" class="btn btn-info">Create</button>
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

    </script>
@endpush
