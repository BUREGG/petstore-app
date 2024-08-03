@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Edit Pet</h1>
    <form action="{{ route('pets.update', $pet['id']) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Imię</label>
            <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $pet['name']) }}" required>
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <select class="form-control" name="status" id="status" required>
                <option value="available" {{ old('status', $pet['status']) == 'available' ? 'selected' : '' }}>Available</option>
                <option value="sold" {{ old('status', $pet['status']) == 'sold' ? 'selected' : '' }}>Sold</option>
                <option value="pending" {{ old('status', $pet['status']) == 'pending' ? 'selected' : '' }}>Pending</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Aktualizuj</button>
        <a href="{{ route('pets.index') }}" class="btn btn-secondary">Cofnij</a>
    </form>
</div>
@endsection
