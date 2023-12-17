<article class="comment_question">
    <p>posted by {{$comment->author->name}}</p>
    <p>{{$comment->content}}</p>
    @if (Auth::check() && ($comment->author_id == Auth::user()->user_id || Auth::user()->isAdmin() || Auth::user()->is_moderator))
        <form method="POST" action="{{ url('/commentquestion/'.$comment->comment_id.'/delete') }}">
            @method('DELETE')
            @csrf
            <button type="submit">Delete Comment</button>
        </form>
        <a class="button" href="{{ url('/commentquestion/'.$comment->comment_id.'/edit') }}"> Edit </a>
    @endif
</article>