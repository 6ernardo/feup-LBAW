@extends('layouts.app')

@section('content')
    <section id="manageusers">
    <h2>User Management</h2>
        <a class="button" href="/manageusers/create">Create Account</a>
        <header>
            <label>Search for user:
                <input type="search" id="search" placeholder="Search by name or email...">
            </label>
        </header>
        <div class="users_table">
            <ul>
                <li>Name</li>
                <li>ID</li>
                <li>Email</li>
                <li>Role</li>
            </ul>
        </div>
        @each('partials.manageuserinstance', $users, 'user')
    </section>
@endsection