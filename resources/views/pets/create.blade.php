@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Add New Pet</h1>
    <form action="{{ route('pets.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Imię</label>
            <input type="text" class="form-control" name="name" id="name" required>
        </div>
        <div class="form-group">
            <label for="status">Wybierz status</label>
            <select class="form-control" name="status" id="status" required>
                <option value="available">Available</option>
                <option value="sold">Sold</option>
                <option value="pending">Pending</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Dodaj zwierzę</button>
        <a href="{{ route('pets.index') }}" class="btn btn-secondary">Cofnij</a>
    </form>
</div>
@endsection
