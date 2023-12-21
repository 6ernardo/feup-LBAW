@extends('layouts.app')

@section('content')
    <section id="profile">
        <h1>Username: {{ $user->name }}</h1>
        @if($user->profile_picture)
            <img src="{{ asset('storage/' . $user->profile_picture) }}" width="200" height="200" alt="User's profile picture">
        @endif
        <p>Email: {{ $user->email }}</p>
        <p>Score: {{ $user->score }}</p>
        @if(Auth::check() && Auth::user()->user_id == $user->user_id)
            <a class="button" href="{{ url('/user/'.$user->user_id.'/edit') }}">Edit Profile</a>
            <a class="button" href="{{ url('/user/'.$user->user_id.'/questions') }}">View My Questions</a>
            <a class="button" href="{{ url('/user/'.$user->user_id.'/answers') }}">View My Answers</a>
            <form method="POST" action="{{ url('/user/'.$user->user_id.'/delete') }}">
                @method('DELETE')
                @csrf
                <button type="submit">Delete my account</button>
            </form>
        @endif
        @if(Auth::check() && Auth::user()->isAdmin())
            <a class="button" href="{{ url('/user/'.$user->user_id.'/edit') }}">Edit Profile</a>
            @if($user->is_blocked)
                <form method="POST" action="{{ url('/manageusers/unblock/'.$user->user_id) }}">
                    @csrf
                    <button type="submit">Unblock</button>
                </form>
            @else
                <form method="POST" action="{{ url('/manageusers/block/'.$user->user_id) }}">
                    @csrf
                    <button type="submit">Block</button>
                </form>
            @endif
            <form method="POST" action="{{ url('/manageusers/changerole/'.$user->user_id) }}">
                @method('PUT')
                @csrf
                <label>
                    @if($user->isAdmin())
                        Current role: Administrator
                    @elseif($user->is_moderator)
                        Current role: Moderator
                    @else
                        Current role: User
                    @endif
                    <select name="role">
                        <option value="user">User</option>
                        <option value="mod">Moderator</option>
                        <option value="admin">Administrator</option>
                    </select>
                </label>
                <button type="submit">Change Role</button>
            </form>
            <form method="POST" action="{{ url('/manageusers/delete/'.$user->user_id) }}">
                @method('DELETE')
                @csrf
                <button type="submit">Delete account</button>
            </form>
        @endif
    </section>
@endsection