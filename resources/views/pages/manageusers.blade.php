@extends('layouts.app')

@section('content')
    <section id="manageusers">
        <a class="button" href="/manageusers/create">Create Account</a>
        <div class="users_table">
            <h2>User Management</h2>
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