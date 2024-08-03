@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">{{ $pet['name'] }}</h1>
    <p><strong>Status:</strong> {{ $pet['status'] }}</p>
    <a href="{{ route('pets.edit', $pet['id']) }}" class="btn btn-warning">Edytuj</a>
    <form action="{{ route('pets.destroy', $pet['id']) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Usuń</button>
    </form>
    <a href="{{ route('pets.index') }}" class="btn btn-secondary">Cofnij</a>
</div>
@endsection
