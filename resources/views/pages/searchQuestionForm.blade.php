@extends('layouts.app')

@section('content')
    <section id="searchQuestionForm">
        <form method="GET">
            @csrf
            <label for="search">Search:</label>
            <input type="text" id="search_query" name="search_query" placeholder="Search for a question">
            <div id="filters_popup">
                <div id="filters_popup_content">
                    <h3>Search Filters</h3>
                    <label for="orderby">Order By</label>
                    <select name="orderby" id="orderby">
                        <option value="scoreasc">Score - ASC</option>
                        <option value="scoredesc">Score - DESC</option>
                        <option value="oldest">Oldest</option>
                        <option value="newest">Newest</option>
                        <option value="relevance" selected>Relevance</option>
                    </select>
                    <label for="tags">Tags</label>
                    @foreach($tags as $tag)
                        <div>
                            <span>{{ $tag->name }}</span>
                            <input type="checkbox" id="tag{{ $tag->tag_id }}" name="tags[]" value="{{ $tag->tag_id }}">
                        </div>
                    @endforeach
                    <button type="button" class="close_filters" onclick="closeFilters()">Close</button>
                </div>
            </div>
            <button type="button" class="open_filters" onclick="openFilters()">Filters</button>
            <button type="submit" id="submitSearch"> Go </button>
        </form>
    </section>
    <h1>Questions</h1>
        <section id="results">
            
        </section>
    
@endsection 