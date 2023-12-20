@extends('layouts.app')

@section('content')
    <div class="alert alert-danger">
        <strong>404 Not Found:</strong> {{ $exception->getMessage() ?? 'The requested page does not exist.' }}
    </div>
@endsection
