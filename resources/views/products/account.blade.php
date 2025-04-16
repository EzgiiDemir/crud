@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>My Account</h3>
                </div>
                <div class="card-body">
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
                        <a href="{{ route('profile.edit') }}" class="btn btn-dark btn-sm">Edit Profile</a>
                    </div>
                    <hr>
                    <div class="mt-4">
                        <h5>Product History</h5>
                        @if($products->isEmpty())
                            <p>No products uploaded yet.</p>
                        @else
                            <table id="products-table" class="table table-striped table-bordered">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Product Code</th>
                                        <th>Name</th>
                                        <th>Created At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                        <tr>
                                            <td>{{ $product->code ?? 'N/A' }}</td>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $product->created_at->format('d M Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>


<script>
    $(document).ready(function () {
        $('#products-table').DataTable({
            pageLength: 5,
            lengthChange: false,
            searching: true,
            ordering: true,
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '📥 Export Excel',
                    title: 'Product_History'
                },
                {
                    extend: 'print',
                    text: '🖨️ Print'
                }
            ]
        });
    });
</script>
@endsection
