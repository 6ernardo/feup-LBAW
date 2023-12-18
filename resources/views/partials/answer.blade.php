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
    @if (Auth::check() && $answer->question->author_id == Auth::user()->user_id)
        <form method="Post" action="{{ url('questions/'.$answer->question->question_id.'/closed') }}">
            @csrf
            @method('PUT')
            <input type="hidden" name="selected_answer_id" value="{{ $answer->answer_id }}">
            <button type="submit">Mark as Correct</button>
        </form>
    @endif
    <section id="answer_comments">
        <h3>Comments</h3>
        @each('partials.commentanswer', $answer->comments, 'comment')
    </section>
    <section id="post_answer_comment">
        <form method="POST" action="{{ url('questions/'.$answer->question_id.'/answer/'.$answer->answer_id.'/comment/create') }}">
            @csrf
            <textarea name="content" id="content" placeholder="Type your comment here..." value="{{ old('description') }}" required></textarea>
            <button type="submit">Submit</button>
        </form>
    </section>
</article>