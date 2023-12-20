@extends('layouts.app')

@section('content')
    <div class="alert alert-danger">
        <strong>401 Unauthorized:</strong> {{ $exception->getMessage() ?? 'Unauthorized access.' }}
    </div>
@endsection
