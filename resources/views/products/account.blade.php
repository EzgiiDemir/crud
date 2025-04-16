@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">

                    <h3>My Account</h3>
                </div>

                <div class="card-body">
                    <!-- Profile Picture Section -->
                    <div class="text-center">
                    <form action="{{ route('profile.changePicture') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
    <img src="{{ Auth::user()->profile_picture ?? 'https://static.vecteezy.com/system/resources/previews/020/765/399/large_2x/default-profile-account-unknown-icon-black-silhouette-free-vector.jpg' }}"
     class="d-block mx-auto rounded-circle"
     style="max-width: 100px;"
     alt="Profile Picture">
        <label for="profile_picture" class="form-label">Change Profile Picture</label>
        <input type="file" class="form-control" name="profile_picture" id="profile_picture" required>
    </div>
    <button type="submit" class="btn btn-primary btn-sm mb-3">Upload New Picture</button>
</form>


                    </div>

                    <hr>

                    <!-- User Info Section -->
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" value="{{ Auth::user()->name }}" disabled>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" value="{{ Auth::user()->email }}" disabled>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" value="********" disabled>
                    </div>

                    <div class="mt-3">
                        <!-- Edit Profile Button (Profil düzenleme sayfasına yönlendirme) -->
                        <a href="{{ route('profile.edit') }}" class="btn btn-dark btn-sm">Edit Profile</a>
                    </div>

                    <hr>

                    <div class="mt-4">
                        <h5>Product History</h5>
                        @if($products->isEmpty())
                            <p>No products uploaded yet.</p>
                        @else
                            <ul class="list-group">
                                @foreach($products as $product)
                                    <li class="list-group-item">
                                        <strong>{{ $product->name }}</strong>
                                        <span class="float-right">{{ $product->created_at->format('d M Y') }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>


                    <!-- Pagination for products -->
                    <div class="mt-3">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
