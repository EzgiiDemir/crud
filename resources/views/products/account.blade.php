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
        <label for="profile_picture" class="form-label">Change Profile Picture</label>
        <input type="file" class="form-control" name="profile_picture" id="profile_picture" required>
    </div>
    <button type="submit" class="btn btn-primary btn-sm">Upload New Picture</button>
</form>


                        <div class="mt-3">
                            <!-- Change Profile Picture Button (Modal veya yeni sayfa için yönlendirme) -->
                            <a href="{{ route('profile.picture.change') }}" class="btn btn-dark btn-sm">Change Profile Picture</a>
                        </div>
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

                    <!-- Product History Section -->
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
