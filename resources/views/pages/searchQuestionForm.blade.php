@extends('layouts.app')

@section('content')
    <section id="searchQuestionForm">
        <form method="GET">
            @csrf
            <label for="search">Search:</label>
            <input type="text" id="search_query" name="search_query" placeholder="Search for a question">
            <button type="button" class="open_filters" onclick="openFilters()">Filters</button>
            <button type="submit" id="submitSearch"> Go </button>
            <div id="filters_popup">
                <div id="filters_popup_content">
                    <h3>Search Filters</h3>
                    <label for="orderby">Order By</label>
                    <select name="order">
                        <option value="scoreasc">Score - ASC</option>
                        <option value="scoredesc">Score - DESC</option>
                        <option value="oldest">Oldest</option>
                        <option value="newest" selected>Newest</option>
                    </select>
                    @foreach($tags as $tag)
                        <label for="tags">Tags</label>
                        <div>
                            <span>{{ $tag->name }}</span>
                            <input type="checkbox" id="tag{{ $tag->tag_id }}" name="tags[]" value="{{ $tag->tag_id }}">
                        </div>
                    @endforeach
                    <button type="button" class="close_filters" onclick="closeFilters()">Close</button>
                </div>
            </div>
        </form>
    </section>
    <h1>Questions</h1>
        <section id="results">
            
        </section>
    
@endsection 