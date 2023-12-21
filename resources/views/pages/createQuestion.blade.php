@extends('layouts.app')

@section('content')
    <form method="POST" action="{{ route('questions.store') }}">
        @csrf
        <label for="title">Title:</label>
        <input type="text" placeholder="eg. How do I get my student card?" name="title" id="title" required>

        <label for="description">Description:</label>
        <textarea name="description" placeholder="Elaborate on your question as needed! (required field)" id="description" required></textarea>

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