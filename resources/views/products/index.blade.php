@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">

<div class="row justify-content-center mt-3">
    <div class="col-md-12">

        @session('success')
            <div class="alert alert-success" role="alert">
                {{ $value }}
            </div>
        @endsession

        <div class="card">
            <div class="card-header">Product List</div>
            <div class="card-body">

            <a href="{{ route('products.create') }}" class="btn btn-dark btn-sm my-2"><i class="bi bi-plus-circle"></i> Add New Product</a>

            @if($products->isEmpty())
                <p>No products uploaded yet.</p>
            @else
                <table class="table table-striped table-bordered" id="productTable">
                    <thead>
                        <tr>
                            <th>S#</th>
                            <th>Image</th>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Currency</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $index => $product)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                @if($product->image)
                                <img src="{{ asset('storage/'. $product->image) }}" alt="Product" style="max-width: 30%;" class="w-full h-auto object-cover rounded-lg">
                                @else
                                    <span>No Image</span>
                                @endif
                                </td>
                                <td>{{ $product->code }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->quantity }}</td>
                                <td>{{ $product->price }}</td>
                                <td>{{ $product->currency }}</td>
                                <td>
                                    <form id="delete-form-{{ $product->id }}" action="{{ route('products.destroy', $product->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')

                                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-secondary btn-sm">
                                            <i class="bi bi-eye"></i> Show
                                        </a>

                                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary btn-sm">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>

                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $product->id }}">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </form>

                                    <div class="modal fade" id="deleteModal{{ $product->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $product->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content text-black">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel{{ $product->id }}">Confirm Delete</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to delete this product?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="button" class="btn btn-danger"
                                                        onclick="event.preventDefault(); document.getElementById('delete-form-{{ $product->id }}').submit();">
                                                        Delete
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

            <hr>

            <h5 class="mt-4">Deleted Products</h5>
            @if($trashedProducts->isEmpty())
                <p>No deleted products.</p>
            @else
                <table class="table table-bordered table-sm">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Deleted At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($trashedProducts as $product)
                            <tr>
                                <td>{{ $product->code }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->deleted_at }}</td>
                                <td>
                                    <form action="{{ route('products.restore', $product->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-success btn-sm"><i class="bi bi-arrow-counterclockwise"></i> Restore</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
<script>
    $(document).ready(function () {
        $('#productTable').DataTable({
            pageLength: 10,
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
