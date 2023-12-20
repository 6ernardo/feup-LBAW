@extends('layouts.app')

@section('content')
<section id="admin_dash">
    <section id="manageusers">
        <h2>User Management</h2>
        <a class="button" href="/manageusers/create">Create User Account</a>
        <header>
            <form>
                <label for="user_search_query">Search for user:</label>
                <div id="search_container">
                        <input type="search" id="user_search_query" placeholder="Search by name">
                    <button type="submit" id="submitUserSearch"> Go </button>
                </div>
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
    <section id="managetags">
        <h2>Tag Management</h2>
        <a class="button" href="/tags/create">Create New Tag</a>
        <section id="tag_listing">
            Current Tags:
            <ul>
                @foreach($tags as $tag)
                    <li><a href="{{ url('/tags/'.$tag->tag_id) }}">{{ $tag->name }}</a></li>
                @endforeach
            </ul>
        </section>
    </section>
</section>
@endsection