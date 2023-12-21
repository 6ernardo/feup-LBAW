@extends('layouts.app')

@section('content')
    <form method="POST" action="{{ '/manageusers/create' }}">
        {{ csrf_field() }}

        <label for="name">Name</label>
        <input id="name" type="text" placeholder="eg. Marta99" name="name" value="{{ old('name') }}" required autofocus>
        @if ($errors->has('name'))
        <span class="error">
            {{ $errors->first('name') }}
        </span>
        @endif

        <label for="email">E-Mail Address</label>
        <input id="email" placeholder="eg. martabferreira1999@gmail.com" type="email" name="email" value="{{ old('email') }}" required>
        @if ($errors->has('email'))
        <span class="error">
            {{ $errors->first('email') }}
        </span>
        @endif

        <label for="role">User Role</label>
        <select id="role" name="role" required>
            <option value="user" selected>User</option>
            <option value="mod">Moderator</option>
            <option value="admin">Administrator</option>
        </select>

        <label for="password">Password</label>
        <input id="password" type="password" name="password" required>
        @if ($errors->has('password'))
        <span class="error">
            {{ $errors->first('password') }}
        </span>
        @endif

        <label for="password-confirm">Confirm Password</label>
        <input id="password-confirm" type="password" name="password_confirmation" required>

        <button type="submit">
        Create User Account
        </button>
    </form>
@endsection