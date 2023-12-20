@extends('layouts.app')

@section('content')
<h2>Main Features</h2>
<p>Some of the Main features of the platform:</p>
<article>
    <h3>Visitors</h3>
    <ul>
        <li>You can login or create a new account</li>
        <li>Browse the platform</li>
        <li>View Questions, Answers and Comments</li>
        <li>See Top and Recent Questions</li>
        <li>See Questions of specific Tags</li>
        <li>Search for specific Questions</li>
    </ul>
</article>
<article>
    <h3>Authenticated Users</h3>
    <ul>
        <li>Post and vote on Questions, Answers and Comments</li>
        <li>View yours and other users profiles</li>
        <li>Edit your own profile</li>
        <li>Keep track of your Questions and Answers</li>
        <li>Mark Answers under your Questions as correct</li>
        <li>Follow Questions and Tags</li>
        <li>Edit and delete your posts</li>
        <li>Delete your account</li>
    </ul>
    <p>As an Authenticated User, you still keep all the privileges of a Visitor.</p>
</article>
<article>
    <h3>Moderators</h3>
    <ul>
        <li>Delete innapropriate or misleading Questions, Answers and Comments from the platform</li>
        <li>Edit Tags of a Question</li>
    </ul>
    <p>Moderators are a special role in the platform, but still keep all privileges of a regular user.</p>
</article>
<article>
    <h3>Administrators</h3>
    <ul>
        <li>Search User accounts</li>
        <li>Manage User accounts</li>
        <li>Block Users</li>
        <li>Create, edit and delete Tags</li>
    </ul>
    <p>Administrators are a special role in the platform, but still keep all privileges of a moderator.</p>
</article>


@endsection