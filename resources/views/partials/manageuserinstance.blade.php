<article class="user">
    <a href="{{ url('/user/'.$user->user_id) }}">
        <ul>
            <li>{{ $user->name }}</li>
            <li>#{{ $user->user_id }}</li>
            <li>{{ $user->email }}</li>
            @if ($user->isAdmin())
                <li>Administrator</li>
            @elseif ($user->is_moderator)
                <li>Moderator</li>
            @else
                <li>User</li>
            @endif
        </ul>
    </a>
</article>