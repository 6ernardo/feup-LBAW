@extends('layouts.app')

@section('content')
<a class="button" href="{{ url('/questions/create') }}"> Post Question </a>

<div id="aba_buttons">
    <button onclick="openTab('topQuestions')">Top</button>
    <button onclick="openTab('newQuestions')">New</button>
    <button onclick="openTab('followedQuestions')">Followed</button>
</div>

<section id="feed">

    <div id="topQuestions" class="tab-content">
        <h1>Top Questions</h1>
        @forelse ($topQuestions as $question)
            <div class="question">
                <a href="{{ url('/questions/'.$question->question_id) }}">
                    <h2>{{ $question->title }}</h2>
                    <p>{{ $question->description }}</p>
                    <p>Score: {{ $question->score }}</p>
                </a>
            </div>
        @empty
            <p>No Questions to show.</p>
        @endforelse
    </div>

    <div id="newQuestions" class="tab-content" style="display: none;">
        <h1>New Questions</h1>
        @forelse ($newQuestions as $question)
            <div class="question">
                <a href="{{ url('/questions/'.$question->question_id) }}">
                    <h2>{{ $question->title }}</h2>
                    <p>{{ $question->description }}</p>
                    <p>Score: {{ $question->score }}</p>
                </a>
            </div>
        @empty
            <p>No Questions to show.</p>
        @endforelse
    </div>
    @if(Auth::check())
        <div id="followedQuestions" class = "tab-content" style="display: none;">
        <h1>Followed Questions</h1>
        @forelse ($followedQuestions as $question)
            <div class="question">
                <a href="{{ url('/questions/'.$question->question_id) }}">
                    <h2>{{ $question->title }}</h2>
                    <p>{{ $question->description }}</p>
                    <p>Score: {{ $question->score }}</p>
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