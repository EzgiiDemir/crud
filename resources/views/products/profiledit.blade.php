@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Profile</h2>

    <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ auth()->user()->name }}">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ auth()->user()->email }}">
        </div>

        <button type="submit" class="btn btn-primary">Update Profile</button>
    </form>
</div>
@endsection
