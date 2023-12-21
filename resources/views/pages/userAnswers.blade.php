@extends('layouts.app')

@section('content')
<table id="my-answers">
    <tr>
        <th>Question</th>
        <th>My Answer</th>
    </tr>
    @foreach($data as $answer)
    <tr>
        <td>
            <a class="button" href="{{ url('/questions/'.$answer->question_id) }}">{{ $answer->question->title }}</a>
        </td>
        <td>
            <h3>{{ $answer->description }}</h3>
        </td>
    </tr>
    @endforeach
</table>
@endsection
