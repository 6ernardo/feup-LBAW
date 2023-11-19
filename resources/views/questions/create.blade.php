<form method="POST" action="{{ route('questions.store') }}">
    @csrf
    <label for="title">Title:</label>
    <input type="text" name="title" id="title" required>

    <label for="description">Description:</label>
    <textarea name="description" id="description" required></textarea>

    <button type="submit">Submit</button>
</form>