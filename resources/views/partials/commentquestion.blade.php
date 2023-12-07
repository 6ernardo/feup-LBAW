<article class="comment_question">
    <p>posted by {{$comment->author->name}}</p>
    <p>{{$comment->content}}</p>
    @if ($comment->author_id == Auth::user()->user_id)
        <form method="POST" action="{{ url('/commentquestion/'.$comment->comment_id.'/delete') }}">
            @method('DELETE')
            @csrf
            <button type="submit">Delete</button>
        </form>
        <a class="button" href="{{ url('/commentquestion/'.$comment->comment_id.'/edit') }}"> Edit </a>
    @endif
</article>