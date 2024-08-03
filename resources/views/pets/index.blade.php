@extends('layouts.app')
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Pets</h1>
        <form method="GET" action="{{ route('pets.index') }}" class="mb-3">
            <div class="form-group">
                <label for="status">Wybierz status:</label>
                <select id="status" name="status" class="form-control">
                    <option value="available" {{ request('status', 'available') == 'available' ? 'selected' : '' }}>
                        Available</option>
                    <option value="sold" {{ request('status') == 'sold' ? 'selected' : '' }}>Sold</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Filtruj</button>
        </form>

        <a href="{{ route('pets.create') }}" class="btn btn-primary mb-3">Dodaj nowe zwierzę</a>
        <div class="list-group">
            @foreach ($pets as $pet)
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <a href="{{ route('pets.show', $pet['id']) }}">{{ $pet['name'] }}</a>
                    <form action="{{ route('pets.destroy', $pet['id']) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Usuń</button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>
@endsection
