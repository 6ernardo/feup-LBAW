@extends('layouts.app')

@section('content')
    <section id=edit_profile>
        <form method="POST" action="{{ '/user/'.$user->user_id.'/edit' }}">
            @method('PUT')
            @csrf
            <input type="text" name="name" placeholder="{{ $user->name }}" value="{{ old('name') }}">
            <input type="email" name="email" placeholder="{{ $user->email }}" value="{{ old('email') }}">
            <input type="password" name="password" placeholder="Password">
            <input type="password" name="password_confirmation" placeholder="Confirm Password">
            <button type="submit"> Submit changes </button>
        </form>
    </section>
@endsection