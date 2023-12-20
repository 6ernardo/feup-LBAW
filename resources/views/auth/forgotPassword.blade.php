@extends('layouts.app')

@section('content')
<h2>Forgot Password</h2>
<p>Insert your email address. You will receive an email with the link to reset your password.</p>
<form method="POST" action="{{ '/forgotpassword' }}">
    @csrf
    <input type="email" id="email" name="email" placeholder="Insert your email">
    <button type="submit">
        Send
    </button>
</form>
@endsection
