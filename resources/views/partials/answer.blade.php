<article class="answer" data-id="{{ $answer->answer_id }}">
    <p>posted by {{$answer->author->name}}</p>
    <p>{{$answer->description}}</p>
    @if (Auth::check() && ($answer->author_id == Auth::user()->user_id || Auth::user()->is_moderator || Auth::user()->isAdmin()))
        <form method="POST" action="{{ url('/answers/'.$answer->answer_id.'/delete') }}">
            @method('DELETE')
            @csrf
            <button type="submit">Delete Answer</button>
        </form>
        <a class="button" href="{{ url('/answers/'.$answer->answer_id.'/edit') }}"> Edit </a>
    @endif

    <div class="answer" id="answer{{ $answer->answer_id }}">
        <button class="button-vote upvote-button" onclick="vote({{ $answer->answer_id }} , 1)">Upvote</button>
        <span class="score">{{ $answer->score }}</span>
        <button class="button-vote downvote-button" onclick="vote({{ $answer->answer_id }} , -1)">Downvote</button>
        <button class="button-vote remove-vote-button" onclick="removeVote({{ $answer->answer_id }})">Remove Vote</button>
    </div>

    @if (Auth::check() && $answer->question->author_id == Auth::user()->user_id)
        <form method="Post" action="{{ url('questions/'.$answer->question->question_id.'/mark_correct') }}">
            @csrf
            @method('PUT')
            <input type="hidden" name="selected_answer_id" value="{{ $answer->answer_id }}">
            <button type="submit">Mark as Correct</button>
        </form>
    @endif
    <section id="answer_comments">
        <h3>Comments</h3>
        <section id="post_answer_comment">
        <form method="POST" action="{{ url('questions/'.$answer->question_id.'/answer/'.$answer->answer_id.'/comment/create') }}">
            @csrf
            <textarea name="content" id="content" placeholder="Type your comment here..." value="{{ old('description') }}" required></textarea>
            <button type="submit">Submit</button>
        </form>
    </section>
        @each('partials.commentanswer', $answer->comments, 'comment')
    </section>
    
</article>