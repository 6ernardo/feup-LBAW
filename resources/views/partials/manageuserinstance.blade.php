<article class="user" data-id="{{ $user->user_id }}">
    <ul>
        <a href="{{ url('/user/'.$user->user_id) }}">
            <li>{{ $user->name }}</li>
            <li>#{{ $user->user_id }}</li>
            <li>{{ $user->email }}</li>
            @if ($user->moderator == FALSE)
                <li>User</li>
            @else
                <li>Moderator</li>
            @endif
        </a>
    </ul>
    <ul>
        <li><a href="{{ url('/user/'.$user->user_id) }}">View profile</a></li>
        <li><a href="{{ url('/user/'.$user->user_id.'/edit') }}">Edit profile</a></li>
        <li>Block</li>
        <li>Ban</li>
        <li>Promote</li>
    </ul>
</article>