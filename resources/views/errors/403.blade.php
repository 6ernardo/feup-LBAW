@extends('layouts.app')

@section('content')
    <div class="alert alert-danger">
        <strong>403 Forbidden:</strong> {{ $exception->getMessage() ?? 'Forbidden access.' }}
    </div>
@endsection
