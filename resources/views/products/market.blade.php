@extends('layouts.app')

@section('content')
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="container py-5">
        <!-- Market Başlık ve Arama -->
        <div class="row mb-5">
            <div class="col-md-8">
                <h1 class="display-4 font-weight-bold text-primary">Community Market</h1>
                <p class="lead ">Discover unique products from our community members</p>
            </div>
            <div class="col-md-4">
                <div class="search-bar">
                    <form action="{{ route('products.market') }}" method="GET">
                        <div class="input-group">
                            <input type="text" name="search" id="search" class="form-control" placeholder="Search products..."
                                   value="{{ request('search') }}">

                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Ürün Grid -->
        <div class="row">
            @forelse($products as $product)
                <div class="col-md-4 mb-4">
                    <div class="card product-card h-100">
                        <!-- Ürün Resmi -->
                        <div class="product-image-container">
                            <img src="{{ asset('storage/'.$product->image) }}" alt="Product"  class="w-100 h-auto object-cover rounded-lg card-img-top">
                            <div class="product-actions">
                                <button class="btn btn-sm btn-light rounded-circle action-btn favorite-btn"
                                        data-product-id="{{ $product->id }}">
                                    <i class="far fa-heart"></i>
                                </button>
                                <button class="btn btn-sm btn-light rounded-circle action-btn share-btn">
                                    <i class="fas fa-share-alt"></i>
                                </button>
                            </div>
                            @if($product->created_at > now()->subDays(7))
                                <span class="badge badge-success new-badge">NEW</span>
                            @endif
                        </div>
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                        <!-- Ürün Detayları -->
                        <div class="card-body ">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title mb-0">{{ $product->name }}</h5>
                                <span class="badge badge-primary bg-dark">{{ $product->code }}</span>
                            </div>
                            <p class="card-text small mb-2">by {{ $product->user->name }}</p>

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="rating">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star text-warning rating-star" data-rating="{{ $i }}" data-product-id="{{ $product->id }}"></i>
                                    @endfor
                                    <span class="small ml-1" id="average-rating-{{ $product->id }}">{{ $product->average_rating ?? '0' }}</span>
                                </div>
                                <h5 class="text-success mb-0">{{ number_format($product->price, 2) }}  <span>{{ $product->currency }}</span></h5>
                            </div>

                            <p class="card-text">{{ Str::limit($product->description, 100) }}</p>
                        </div>

                        <!-- Ürün Footer (Aksiyon Butonları) -->
                        <div class="card-footer bg-white border-top-0">
                            <div class="d-flex justify-content-between">
                                <div class="d-flex">
                                    <button class="btn btn-outline-primary btn-sm like-btn" data-product-id="{{ $product->id }}">
                                        <i class="far fa-thumbs-up"></i>
                                        <span class="like-count" id="like-count-{{ $product->id }}">{{ $product->like_count ?? '0' }}</span>
                                    </button>

                                    <button class="btn btn-outline-danger btn-sm dislike-btn ml-2" data-product-id="{{ $product->id }}">
                                        <i class="far fa-thumbs-down"></i>
                                    </button>
                                </div>

                                <button class="btn btn-outline-secondary btn-sm comment-btn"
                                        data-toggle="modal" data-target="#commentModal-{{ $product->id }}">
                                    <i class="far fa-comment"></i>
                                    <span id="comment-count-{{ $product->id }}">{{ $product->comments_count ?? '0' }}</span>
                                </button>

                                <button class="btn btn-primary btn-sm order-btn">
                                    <i class="fas fa-shopping-cart"></i><a href="{{ route('payment') }}">Order Now </a>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Yorum Modalı (Her Ürün İçin) -->
                <div class="modal fade" id="commentModal-{{ $product->id }}" tabindex="-1" role="dialog"
                     aria-labelledby="commentModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="commentModalLabel">Comments for {{ $product->name }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- Yorum Listesi -->
                                <div class="comments-section mb-4">
                                    @foreach($product->comments as $comment)
                                        <div class="d-flex align-items-start p-3 mb-3 rounded shadow-sm" style="background-color: #f9f9f9;">
                                            <img src="{{ Auth::user()->profile_picture ?? 'https://static.vecteezy.com/system/resources/previews/020/765/399/large_2x/default-profile-account-unknown-icon-black-silhouette-free-vector.jpg' }}"
                                                 class="rounded-circle me-3"
                                                 style="width: 50px; height: 50px; object-fit: cover;"
                                                 alt="Profile Picture">
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1 fw-bold">{{ $comment->user->name }}</h6>
                                                <p class="mb-2 p-2 rounded text-white" style="background-color: #0d6efd;">{{ $comment->content }}</p>
                                                <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                            </div>
                                        </div>

                                    @endforeach
                                </div>

                                <!-- Yorum Yazma Formu -->
                                <form class="comment-form" data-product-id="{{ $product->id }}">
                                    <div class="form-group">
                                        <textarea class="form-control" rows="3" placeholder="Write your comment..."></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-sm mt-2">Post Comment</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info text-center">
                            <i class="fas fa-info-circle fa-2x mb-3"></i>
                            <h4>No products found</h4>
                            <p>There are currently no products available in the market.</p>
                            @auth
                                <a href="{{ route('products.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Add Your First Product
                                </a>
                            @endauth
                        </div>
                    </div>
            @endforelse
        </div>

        <!-- Sayfalama -->
        @if($products->hasPages())
            <div class="row mt-4">
                <div class="col-12 d-flex justify-content-center">
                    {{ $products->links() }}
                </div>
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Yıldız değerlendirmesi işlemi
            $(document).ready(function() {
                $('.rating-star').on('click', function() {
                    var rating = $(this).data('rating');
                    var productId = $(this).data('product-id');

                    $.ajax({
                        url: '/rate-product', // POST isteği atacağımız route
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            rating: rating,
                            product_id: productId
                        },
                        success: function(response) {
                            // Başarılı olursa ortalama rating güncelleyebilirsin
                            $('#average-rating-' + productId).text(response.new_average_rating);
                        },
                        error: function() {
                            alert('Error saving rating.');
                        }
                    });
                });
            });

            $(document).ready(function() {
                $('.like-btn').on('click', function() {
                    var productId = $(this).data('product-id');

                    $.ajax({
                        url: '/product/' + productId + '/increase',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            $('#like-count-' + productId).text(response.like_count);
                        },
                        error: function() {
                            alert('Failed to increase like.');
                        }
                    });
                });

                $('.dislike-btn').on('click', function() {
                    var productId = $(this).data('product-id');

                    $.ajax({
                        url: '/product/' + productId + '/decrease',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            $('#like-count-' + productId).text(response.like_count);
                        },
                        error: function() {
                            alert('Failed to decrease like.');
                        }
                    });
                });
            });

            function postComment(productId, commentText) {
                fetch('/products/comment', { // Ensure this matches the correct route
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ product_id: productId, content: commentText })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.new_comment_count !== undefined) {
                            document.getElementById(`comment-count-${productId}`).innerText = data.new_comment_count;
                        }
                    })  .catch(error => {
                    console.error('Error posting comment:', error);
                });
            }

            document.querySelectorAll('.comment-form').forEach(form => {
                form.addEventListener('submit', function(event) {
                    event.preventDefault();
                    const productId = this.getAttribute('data-product-id');
                    const commentText = this.querySelector('textarea').value;

                    postComment(productId, commentText);

                    // Optionally clear the form after submission
                    this.querySelector('textarea').value = '';
                });
            });


            // Yıldız değerlendirmesi işlevi
            function rateProduct(productId, rating) {
                fetch('/products/rate', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ product_id: productId, rating: rating })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.new_avg_rating) {
                            document.getElementById('average-rating').innerText = `Average Rating: ${data.new_avg_rating}`;
                        }
                    });
            }

            // Beğeni işlevi
            function toggleLike(productId) {
                fetch('/products/like', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ product_id: productId })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.new_like_count !== undefined) {
                            document.getElementById(`like-count-${productId}`).innerText = data.new_like_count;
                        }
                    });
            }


        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


    </script>

    <style>
        .product-card {
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid rgba(0,0,0,0.1);
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        .product-image-container {
            position: relative;
            overflow: hidden;
            height: 200px;
        }

        .product-image-container img {
            object-fit: cover;
            width: 100%;
            height: 100%;
            transition: transform 0.5s ease;
        }

        .product-card:hover .product-image-container img {
            transform: scale(1.05);
        }

        .product-actions {
            position: absolute;
            top: 10px;
            right: 10px;
            display: flex;
            flex-direction: column;
        }

        .action-btn {
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 5px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .product-card:hover .action-btn {
            opacity: 1;
        }

        .favorite-btn.active {
            color: #dc3545;
        }

        .new-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            font-size: 0.8rem;
        }

        .like-btn.active {
            color: #007bff;
        }

        .rating {
            font-size: 0.9rem;
        }

        .rating-star {
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .product-actions {
                opacity: 1;
            }

            .action-btn {
                opacity: 1;
            }
        }
        ::placeholder{
            color: #007bff !important;
        }
    </style>

@endsection
