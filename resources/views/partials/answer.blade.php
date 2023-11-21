<article class="answer" data-id="{{ $answer->answer_id }}">
    <p>posted by {{$answer->author->name}}</p>
    <p>{{$answer->description}}</p>
    @if ($answer->author_id == Auth::user()->user_id)
        <form method="POST" action="{{ url('/answers/'.$answer->answer_id.'/delete') }}">
            @method('DELETE')
            @csrf
            <button type="submit">Delete</button>
        </form>
        <a class="button" href="{{ url('/answers/'.$answer->answer_id.'/edit') }}"> Edit </a>
    @endif
</article>