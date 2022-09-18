@extends('system_admin.layouts.app')

@section('title', 'Create User')

@section('content')
    <div>
        <section class="box">
            <header class="panel_header">
                <h2 class="title pull-left"> <i class="fa-solid fa-shield-halved"></i> &nbsp; User Information</h2>
            </header>
            <div class="content-body">
                {{-- <img src="{{ asset('user/' . $user->image) }}" alt=""> --}}
                <p>Name : {{$user->name}}</p>
                <p>Phone : {{$user->phone}}</p>
                <p>Role :
                    @foreach ($user->roles as $role)
                        {{ $role->name }}
                    @endforeach
                </p>
            </div>
        </section>
    </div>

@endsection


@push('script')
    <script>

    </script>
@endpush
