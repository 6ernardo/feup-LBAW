@extends('layouts.app')

@section('content')
    <form method="POST" action="{{ '/resetpassword' }}">
        @csrf
        <input type="email" id="email" name="email" placeholder="Insert your email">
        <input type="password" id="password" name="password" placeholder="Password">
        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password">
        <input type="hidden" id="token" name="token" value="{{ $token }}">
        <button type="submit">
            Reset password
        </button>
    </form>
@endsection
