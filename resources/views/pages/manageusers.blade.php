@extends('layouts.app')

@section('content')
    <section id="manageusers">
        @each('partials.manageuserinstance', $users, 'user')
    </section>
@endsection