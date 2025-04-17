@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">

<div class="row justify-content-center mt-3">
    <div class="col-12 col-md-8">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between flex-column flex-md-row">
                    <div>Product Information</div>
                    <div>
                        <a href="{{ route('products.index') }}" class="btn btn-dark btn-sm">&larr; Back</a>
                    </div>
                </div>
            </div>
            <div class="card-body">

                <div class="row mb-3">
                    <label for="code" class="col-12 col-md-4 col-form-label text-md-end text-start"><strong>Code:</strong></label>
                    <div class="col-12 col-md-6" style="line-height: 35px;">
                        {{ $product->code }}
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="name" class="col-12 col-md-4 col-form-label text-md-end text-start"><strong>Name:</strong></label>
                    <div class="col-12 col-md-6" style="line-height: 35px;">
                        {{ $product->name }}
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="quantity" class="col-12 col-md-4 col-form-label text-md-end text-start"><strong>Quantity:</strong></label>
                    <div class="col-12 col-md-6" style="line-height: 35px;">
                        {{ $product->quantity }}
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="price" class="col-12 col-md-4 col-form-label text-md-end text-start"><strong>Price:</strong></label>
                    <div class="col-12 col-md-6" style="line-height: 35px;">
                        {{ $product->price }}
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="description" class="col-12 col-md-4 col-form-label text-md-end text-start"><strong>Description:</strong></label>
                    <div class="col-12 col-md-6" style="line-height: 35px;">
                        {{ $product->description }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
@endsection
