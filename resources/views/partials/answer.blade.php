<article class="answer" data-id="{{ $answer->answer_id }}">
    <p>posted by {{$answer->author->name}}</p>
    <p>{{$answer->description}}</p>
    @if ($answer->author_id == Auth::user()->user_id)
        <form method="POST">
            @method('DELETE')
            @csrf
            <button type="submit">Delete</button>
        </form>
    @endif
</article>