@extends('layouts.app')

@section('content')
    <form method="POST" action="{{ route('questions.store') }}">
        @csrf
        <label for="title">Title:</label>
        <input type="text" name="title" id="title" required>

        <label for="description">Description:</label>
        <textarea name="description" id="description" required></textarea>

        <div class="tag-dropdown">
                <button onclick="toggleDropdown()">Tag List</button>
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
    <button type="submit">Create Question</button>
    </form>
@endsection
<script>
    function toggleDropdown() {
    var dropdownMenu = document.querySelector('.dropdown-menu');
    dropdownMenu.style.display = (dropdownMenu.style.display === 'block') ? 'none' : 'block';
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