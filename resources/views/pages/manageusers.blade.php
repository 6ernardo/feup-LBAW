@extends('layouts.app')

@section('content')
    <section id="manageusers">
    <h2>User Management</h2>
        <a class="button" href="/manageusers/create">Create Account</a>
        <header>
            <form>
                <label>Search for user:
                    <input type="search" id="user_search_query" placeholder="Search by name">
                </label>
                <button type="submit" id="submitUserSearch"> Go </button>
            </form>
        </header>
        <div class="users_table">
            <ul>
                <li>Name</li>
                <li>ID</li>
                <li>Email</li>
                <li>Role</li>
            </ul>
        </div>
        <section id="user_listing">
            @each('partials.manageuserinstance', $users, 'user')
        </section>
    </section>
@endsection