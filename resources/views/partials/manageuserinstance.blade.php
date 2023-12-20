<article class="user">
    <ul>
        <a href="{{ url('/user/'.$user->user_id) }}">
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
        </a>
    </ul>
</article>