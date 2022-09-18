@extends('layouts.app')


@section('content')

<form class="winningresult-form" action="{{ route('store.winning') }}" method="POST">
    @csrf
    <label for="number">Number</label>
    <input type="text" name="number">
    <select name="type" id="">
        <option value="2D">2D</option>
        <option value="3D">3D</option>

        <option value="lonepyine">LonePyine</option>

    </select>

    <button type="submit">Confirm</button>

</form>

@endsection
