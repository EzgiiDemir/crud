@extends('layouts.app')

@section('content')

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

@endsection
