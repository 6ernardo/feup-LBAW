@extends('layouts.app')

@section('content')
    <section id="edit_question">
        <form method="POST" action="{{ '/questions/'.$question->question_id.'/edit' }}">
            @method('PUT')
            @csrf
            <label for="title">Title:</label>
            <input type="text" name="title" id="title" placeholder="{{ $question->title }}" value="{{ old('title') }}">

            <label for="description">Description:</label>
            <textarea name="description" id="description" placeholder="{{ $question->description }}" value="{{ old('description') }}"></textarea>

            <div class="tag-dropdown">
                <button type="button" onclick="toggleDropdown()">Tag List</button> 
                <div class="dropdown-menu" style="display: none;">
                <label for="tags">Select Tags:</label><br>
                     @foreach($tags as $tag)
                        <div>
                            <span>{{ $tag->name }}</span>
                            <input type="checkbox" id="tag{{ $tag->tag_id }}" name="tags[]" value="{{ $tag->tag_id }}">
                        </div>
                     @endforeach
                </div>
            </div>

            <button type="submit">Submit</button>
        </form>
    </section>
@endsection
<script>
    function toggleDropdown(event) {
    var dropdownMenu = document.querySelector('.dropdown-menu');
    dropdownMenu.style.display = (dropdownMenu.style.display === 'block') ? 'none' : 'block';
    event.stopPropagation();
}

document.querySelectorAll('.dropdown-menu input[type="checkbox"]').forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            var checkboxId = this.id;
            var label = document.querySelector('label[for="' + checkboxId + '"]');
            if (this.checked) {
                label.classList.add('selected'); 
                label.classList.remove('selected');
            }
        });
    });

document.addEventListener('click', function(event) {
    var dropdown = document.querySelector('.tag-dropdown');
    if (!dropdown.contains(event.target)) {
        var dropdownMenu = document.querySelector('.dropdown-menu');
        dropdownMenu.style.display = 'none';
    }
});
</script>