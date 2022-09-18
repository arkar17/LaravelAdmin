@extends('system_admin.layouts.app')

@section('title', 'Edit User')

@section('content')
    <div>
        <section class="box">
            <header class="panel_header">
                <h2 class="title pull-left"> <i class="fa-solid fa-shield-halved"></i> &nbsp; Update User</h2>
            </header>
            <div class="content-body">
                <form action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-8 col-sm-9 col-xs-10">
                            <div class="form-group @error('name') has-error @enderror">
                                <label class="form-label" for="name">Name</label>
                                <div class="">
                                    <input type="text" class="form-control" name="name" id="name"
                                        value="{{ old('name', $user->name) }}" autofocus>
                                    @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group @error('phone') has-error @enderror">
                                <label class="form-label" for="phone">Phone</label>
                                <div class="">
                                    <input type="number" class="form-control" name="phone" id="phone"
                                        value="{{ old('phone', $user->phone) }}">
                                    @error('phone')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group @error('profile_img') has-error @enderror">
                                <label for="profile_img fs">Profile Image</label>
                                <input type="file" class="form-control form-control-md" id="profile_img"
                                    name="profile_img">
                                <div class="preview_img mt-2"></div>

                            </div>

                            <div class="form-group @error('role') has-error @enderror">
                                <label class="form-label" for="" for="role">Role</label>

                                <select class="form-control m-bot15 select2" name="roles[]" multiple>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}"
                                            @if (in_array($role->id, $old_roles)) selected @endif>{{ $role->name }}</option>
                                    @endforeach
                                </select>

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
