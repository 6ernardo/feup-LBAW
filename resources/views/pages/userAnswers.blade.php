@extends('layouts.app')

@section('content')
<table>
    <tr>
        <th>Question</th>
        <th>My Answer</th>
    </tr>
    <tr>
    @foreach($data as $answer)
        <td>
        <a class="button" href="{{ url('/questions/'.$answer->question_id) }}">{{ $answer->question->title }}</a>
        </td>
        <td>
            <h3>{{ $answer->description }}</h3>
        </td>
        @endforeach
    </tr>
</table>
@endsection
