@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
<div class="container py-5">
    <!-- Market Başlık ve Arama -->
    <div class="row mb-5">
        <div class="col-md-8">
            <h1 class="display-4 font-weight-bold text-primary">Community Market</h1>
            <p class="lead ">Discover unique products from our community members</p>
        </div>
        <div class="col-md-4">
            <div class="search-bar">
                <form action="{{ route('products.index') }}" method="GET">
                    <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search products..."
       value="{{ request('search') }}" style="::placeholder { color: orange; }">

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

    <!-- Filtreleme ve Sıralama -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex flex-wrap align-items-center">
                <span class="mr-2 ">Filter:</span>
                <div class="btn-group btn-group-sm mr-3">
                    <button type="button" class="btn btn-outline-primary active">All</button>
                    <button type="button" class="btn btn-outline-primary">Popular</button>
                    <button type="button" class="btn btn-outline-primary">Newest</button>
                </div>

                <span class="mr-2 ">Categories:</span>
                <div class="btn-group btn-group-sm">
                    <button type="button" class="btn btn-outline-secondary">Clothing</button>
                    <button type="button" class="btn btn-outline-secondary">Electronics</button>
                    <button type="button" class="btn btn-outline-secondary">Home</button>
                    <button type="button" class="btn btn-outline-secondary">Other</button>
                </div>
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
                <img src="{{ asset('storage/'.$product->image) }}" alt="Product"  class="card-img-top">
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

                <!-- Ürün Detayları -->
                <div class="card-body ">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h5 class="card-title mb-0">{{ $product->name }}</h5>
                        <span class="badge badge-primary bg-dark">{{ $product->code }}</span>
                    </div>
                    <p class="card-text  small mb-2">by {{ $product->user->name }}</p>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="rating">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="far fa-star text-warning"></i>
                            <span class="small  ml-1">(24)</span>
                        </div>
                        <h5 class="text-success mb-0">{{ number_format($product->price, 2) }}  <td>{{ $product->currency }}</td></h5>
                    </div>

                    <p class="card-text">{{ Str::limit($product->description, 100) }}</p>
                </div>

                <!-- Ürün Footer (Aksiyon Butonları) -->
                <div class="card-footer bg-white border-top-0">
                    <div class="d-flex justify-content-between">
                        <button class="btn btn-outline-primary btn-sm like-btn"
                                data-product-id="{{ $product->id }}">
                            <i class="far fa-thumbs-up"></i>
                            <span class="like-count">12</span>
                        </button>
                        <button class="btn btn-outline-secondary btn-sm comment-btn"
                                data-toggle="modal" data-target="#commentModal-{{ $product->id }}">
                            <i class="far fa-comment"></i>
                            <span>5</span>
                        </button>
                        <button class="btn btn-primary btn-sm order-btn">
                            <i class="fas fa-shopping-cart"></i> Order Now
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
                            <div class="media mb-3">
                                <img src="https://via.placeholder.com/50" class="mr-3 rounded-circle" alt="User">
                                <div class="media-body">
                                    <h6 class="mt-0">John Doe</h6>
                                    <p class="small ">2 days ago</p>
                                    <p>This product is amazing! I love the quality and the design.</p>
                                    <button class="btn btn-sm btn-outline-secondary">Reply</button>
                                </div>
                            </div>
                            <!-- Diğer yorumlar... -->
                        </div>

                        <!-- Yorum Yazma Formu -->
                        <form class="comment-form">
                            <div class="form-group">
                                <textarea class="form-control" rows="3" placeholder="Write your comment..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">Post Comment</button>
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

<!-- Ürün Detay Modalı -->
<div class="modal fade" id="productDetailModal" tabindex="-1" role="dialog" aria-hidden="true">
    <!-- Bu modal dinamik olarak AJAX ile doldurulabilir -->
</div>

<style>
    .product-card {
        border-radius: 10px;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: 1px solid rgba(0,0,0,0.1);
    }
    .form-control::placeholder {
        color: #007bff;
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

    @media (max-width: 768px) {
        .product-actions {
            opacity: 1;
        }

        .action-btn {
            opacity: 1;
        }
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        // Beğeni butonu işlevselliği
        $('.like-btn').click(function() {
            $(this).toggleClass('active');
            const productId = $(this).data('product-id');
            // AJAX isteği ile beğeni işlemi
        });

        // Favori butonu işlevselliği
        $('.favorite-btn').click(function() {
            $(this).toggleClass('active');
            $(this).find('i').toggleClass('far fas');
            const productId = $(this).data('product-id');
            // AJAX isteği ile favori işlemi
        });

        // Ürün detay modalını açma
        $('.product-card').click(function(e) {
            if (!$(e.target).closest('.action-btn, .order-btn, .comment-btn').length) {
                const productId = $(this).find('.like-btn').data('product-id');
                // AJAX ile ürün detaylarını yükle ve modalı aç
            }
        });
    });
</script>
@endsection