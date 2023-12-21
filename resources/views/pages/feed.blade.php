@extends('layouts.app')

@section('content')
<section id="feed">

<a class="button" href="{{ url('/questions/create') }}"> Post Question </a>

<span class="tooltip">(?)<span class="tooltiptext">This is your main feed! Click the button to post a new question (you will need to have an account) or just keep browsing!</span></span> 

<div id="aba_buttons">
    <button onclick="openTab('topQuestions')">Top</button>
    <button onclick="openTab('newQuestions')">New</button>
    <button onclick="openTab('followedQuestions')">Followed</button>
    <span class="tooltip">(?)<span class="tooltiptext">Choose a feed of Questions to see! Most upvoted, newest, or from accounts/ tags that you follow!</span></span>
</div>



    <div id="topQuestions" class="tab-content">
        <h2>Top Questions</h2>
        @forelse ($topQuestions as $question)
            <div class="question">
                <a href="{{ url('/questions/'.$question->question_id) }}">
                    <h2>{{ $question->title }}</h2>
                    <p>Score:{{ $question->score }} | posted by {{ $question->author->name }} on {{ $question->timestamp }} </p>
                </a>
            </div>
        @empty
            <p>No Questions to show.</p>
        @endforelse
    </div>

    <div id="newQuestions" class="tab-content" style="display: none;">
        <h2>New Questions</h2>
        @forelse ($newQuestions as $question)
            <div class="question">
                <a href="{{ url('/questions/'.$question->question_id) }}">
                    <h2>{{ $question->title }}</h2>
                    <p>Score:{{ $question->score }} | posted by {{ $question->author->name }} on {{ $question->timestamp }} </p>
                </a>
            </div>
        @empty
            <p>No Questions to show.</p>
        @endforelse
    </div>
    @if(Auth::check())
        <div id="followedQuestions" class = "tab-content" style="display: none;">
        <h2>Followed Questions</h2>
        @forelse ($followedQuestions as $question)
            <div class="question">
                <a href="{{ url('/questions/'.$question->question_id) }}">
                    <h2>{{ $question->title }}</h2>
                    <p>Score:{{ $question->score }} | posted by {{ $question->author->name }} on {{ $question->timestamp }} </p>
                </a>
            </div>
        @empty
            <p>No Questions to show.</p>
        @endforelse
        </div>
    @endif
</section>
    <script src="{{ asset('js/feed_tab.js') }}"></script>
</section>
@endsection