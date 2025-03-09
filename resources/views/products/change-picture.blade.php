@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Change Profile Picture</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('profile.update-picture') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="profile_picture">Upload New Profile Picture:</label>
            <input type="file" name="profile_picture" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary mt-3">Update Picture</button>
    </form>
</div>
@endsection
