@extends('frontend.layouts.master')

@section('meta')
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name='copyright' content=''>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="online shop, purchase, cart, ecommerce site, best online shopping">
    <meta name="description" content="{{ $product_detail->summary }}">
    <meta property="og:url" content="{{ route('product-detail', $product_detail->slug) }}">
    <meta property="og:type" content="article">
    <meta property="og:title" content="{{ $product_detail->title }}">
    <meta property="og:image" content="{{ $product_detail->photo }}">
    <meta property="og:description" content="{{ $product_detail->description }}">
@endsection
@section('title', 'Artisan || Chi Tiết Sản Phẩm')
@section('main-content')

    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{ route('home') }}">Trang Chủ<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="">Chi Tiết Sản Phẩm</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <!-- Shop Single -->
    <section class="shop single section " style="margin-top: 0;">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-lg-6 col-12">
                            <div class="product-gallery">
                                @php
                                    $photos = explode(',', $product_detail->photo); // Chuyển chuỗi thành mảng
                                @endphp

                                @if (!empty($photos) && count($photos) > 0)
                                    <!-- Ảnh chính -->
                                    <div class="main-image">
                                        <button class="prev-btn" onclick="changeImage(-1)">&#10094;</button>
                                        <img id="currentImage" src="{{ url(trim($photos[0])) }}" alt="Product Image"
                                            class="img-fluid">
                                        <button class="next-btn" onclick="changeImage(1)">&#10095;</button>
                                    </div>

                                    <!-- Danh sách thumbnail -->
                                    <div class="image-thumbnails">
                                        @foreach ($photos as $index => $data)
                                            <img src="{{ url(trim($data)) }}" alt="Thumbnail"
                                                class="thumbnail {{ $index >= 6 ? 'hidden-thumbnail' : '' }}"
                                                onclick="selectImage({{ $index }})"
                                                data-index="{{ $index }}">
                                        @endforeach
                                        @if (count($photos) > 4)
                                            <span class="more-thumbnails">...</span> <!-- Dấu "..." báo hiệu còn ảnh -->
                                        @endif
                                    </div>
                                @else
                                    <p>Không có hình ảnh để hiển thị.</p>
                                @endif
                            </div>

                            <script>
                                let images = @json($photos);
                                let currentIndex = 0;

                                function changeImage(step) {
                                    currentIndex += step;
                                    if (currentIndex < 0) {
                                        currentIndex = images.length - 1;
                                    } else if (currentIndex >= images.length) {
                                        currentIndex = 0;
                                    }
                                    document.getElementById("currentImage").src = images[currentIndex].trim();
                                    updateThumbnails();
                                }

                                function selectImage(index) {
                                    currentIndex = index;
                                    document.getElementById("currentImage").src = images[currentIndex].trim();
                                    updateThumbnails();
                                }

                                function updateThumbnails() {
                                    let thumbnails = document.querySelectorAll('.thumbnail');
                                    thumbnails.forEach((thumb, index) => {
                                        if (index >= currentIndex && index < currentIndex + 4) {
                                            thumb.classList.remove('hidden-thumbnail');
                                        } else {
                                            thumb.classList.add('hidden-thumbnail');
                                        }
                                    });
                                }
                            </script>

                            <style>
                                .breadcrumbs {
                                    margin-bottom: 0;
                                    /* Loại bỏ khoảng cách dưới */
                                    padding-bottom: 10px;
                                    /* Giữ khoảng cách nhỏ */
                                }

                                .shop.single.section {
                                    margin-top: 10px;
                                    /* Giảm khoảng cách */
                                    padding-top: 0;
                                    /* Nếu có padding, giảm hoặc loại bỏ */
                                }

                                .product-gallery {
                                    text-align: center;
                                    position: relative;
                                }

                                .main-image {
                                    position: relative;
                                    display: inline-block;
                                }

                                .main-image img {
                                    width: 100%;
                                    max-height: 540px;
                                    object-fit: contain;
                                    border-radius: 10px;
                                }

                                .prev-btn,
                                .next-btn {
                                    position: absolute;
                                    top: 50%;
                                    transform: translateY(-50%);
                                    background: rgba(0, 0, 0, 0.5);
                                    color: white;
                                    border: none;
                                    font-size: 20px;
                                    padding: 10px;
                                    cursor: pointer;
                                    z-index: 100;
                                }

                                .prev-btn {
                                    left: 10px;
                                }

                                .next-btn {
                                    right: 10px;
                                }

                                .prev-btn:hover,
                                .next-btn:hover {
                                    background: rgba(0, 0, 0, 0.8);
                                }

                                .image-thumbnails {
                                    margin-top: 10px;
                                    display: flex;
                                    justify-content: center;
                                    gap: 10px;
                                    align-items: center;
                                }

                                .thumbnail {
                                    width: 60px;
                                    height: 60px;
                                    object-fit: cover;
                                    border-radius: 5px;
                                    cursor: pointer;
                                    transition: 0.3s;
                                }

                                .thumbnail:hover {
                                    border: 2px solid #007bff;
                                    transform: scale(1.1);
                                }

                                /* .hidden-thumbnail {
                                                                                                                            display: none;
                                                                                                                        } */

                                .more-thumbnails {
                                    font-size: 24px;
                                    color: #888;
                                }
                            </style>
                        </div>




                        <div class="col-lg-6 col-12">
                            <div class="product-des">
                                <!-- Description -->
                                <div class="short">
                                    <h4>{{ $product_detail->title }}</h4>
                                    <div class="rating-main">
                                        <ul class="rating">
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            {{-- <li><i class="fa fa-star-o"></i></li> --}}

                                        </ul>
                                        <a href="#" class="total-review">({{ rand(1, 100) }}) Đánh Giá</a>

                                    </div>
                                    @php
                                        $after_discount =
                                            $product_detail->price -
                                            ($product_detail->price * $product_detail->discount) / 100;
                                    @endphp
                                    <p class="price">
                                        <span class="discount">{{ number_format($after_discount, 0) }}đ</span>
                                        @if ($product_detail->discount > 0)
                                            <s>{{ number_format($product_detail->price, 0) }}đ</s>
                                        @endif
                                    </p>
                                    <p class="description">{!! $product_detail->summary !!}</p>

                                </div>
                                <!--/ End Description -->
                                <!-- Color -->
                                {{-- <div class="color">
												<h4>Available Options <span>Color</span></h4>
												<ul>
													<li><a href="#" class="one"><i class="ti-check"></i></a></li>
													<li><a href="#" class="two"><i class="ti-check"></i></a></li>
													<li><a href="#" class="three"><i class="ti-check"></i></a></li>
													<li><a href="#" class="four"><i class="ti-check"></i></a></li>
												</ul>
											</div> --}}
                                <!--/ End Color -->
                                <!-- Size -->

                                <!--/ End Size -->
                                <!-- Product Buy -->
                                <div class="product-buy">
                                    <form action="{{ route('single-add-to-cart') }}" method="POST">
                                        @csrf
                                        <div class="quantity">
                                            <h6>Số lượng :</h6>
                                            <!-- Input Order -->
                                            <div class="input-group">
                                                <div class="button minus">
                                                    <button type="button" class="btn btn-primary btn-number"
                                                        disabled="disabled" data-type="minus" data-field="quant[1]">
                                                        <i class="ti-minus"></i>
                                                    </button>
                                                </div>
                                                <input type="hidden" name="slug" value="{{ $product_detail->slug }}">
                                                <input type="text" name="quant[1]" class="input-number" data-min="1"
                                                    data-max="1000000" value="1" id="quantity">
                                                <div class="button plus">
                                                    <button type="button" class="btn btn-primary btn-number"
                                                        data-type="plus" data-field="quant[1]">
                                                        <i class="ti-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <!--/ End Input Order -->
                                        </div>
                                        <div class="add-to-cart mt-4">
                                            <button type="submit" class="btn">Thêm vào giỏ hàng</button>
                                            <a href="{{ route('add-to-wishlist', $product_detail->slug) }}"
                                                class="btn min"><i class="ti-heart"></i></a>
                                        </div>
                                    </form>

                                    <p class="cat">Danh mục sản phẩm :<a
                                            href="{{ route('product-cat', $product_detail->cat_info['slug']) }}">{{ $product_detail->cat_info['title'] }}</a>
                                    </p>
                                    @if ($product_detail->sub_cat_info)
                                        <p class="cat mt-1">Danh mục nhánh :<a
                                                href="{{ route('product-sub-cat', [$product_detail->cat_info['slug'], $product_detail->sub_cat_info['slug']]) }}">{{ $product_detail->sub_cat_info['title'] }}</a>
                                        </p>
                                    @endif
                                    <p class="availability">Kho : @if ($product_detail->stock > 0)
                                            <span class="badge badge-success">{{ $product_detail->stock }}</span>
                                        @else
                                            <span class="badge badge-danger">{{ $product_detail->stock }}</span>
                                        @endif
                                    </p>
                                </div>
                                <!--/ End Product Buy -->
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="product-info">
                                <div class="nav-main">
                                    <!-- Tab Nav -->
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item"><a class="nav-link active" data-toggle="tab"
                                                href="#description" role="tab">Mô Tả</a></li>
                                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#reviews"
                                                role="tab">Đánh Giá</a></li>
                                    </ul>
                                    <!--/ End Tab Nav -->
                                </div>
                                <div class="tab-content" id="myTabContent">
                                    <!-- Description Tab -->
                                    <div class="tab-pane fade show active" id="description" role="tabpanel">
                                        <div class="tab-single">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="single-des">
                                                        <div class="description-content">
                                                            <p>{!! $product_detail->description !!}</p>
                                                        </div>
                                                        <button class="toggle-button">Xem thêm ▼</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <!--/ End Description Tab -->
                                    <!-- Reviews Tab -->
                                    <div class="tab-pane fade" id="reviews" role="tabpanel">
                                        <div class="tab-single review-panel">
                                            <div class="row">
                                                <div class="col-12">

                                                    <!-- Review -->
                                                    <div class="comment-review">
                                                        <div class="add-review">
                                                            <h5>Thêm đánh giá</h5>
                                                            <p>Email của bạn sẽ không được công khai, bạn vui lòng đánh giá
                                                                số sao nha.</p>
                                                        </div>
                                                        <h4>Đánh giá (sao) <span class="text-danger">*</span></h4>
                                                        <div class="review-inner">
                                                            <!-- Form -->
                                                            @auth
                                                                <form class="form" method="post"
                                                                    action="{{ route('review.store', $product_detail->slug) }}">
                                                                    @csrf
                                                                    <div class="row">
                                                                        <div class="col-lg-12 col-12">
                                                                            <div class="rating_box">
                                                                                <div class="star-rating">
                                                                                    <div class="star-rating__wrap">
                                                                                        <input class="star-rating__input"
                                                                                            id="star-rating-5" type="radio"
                                                                                            name="rate" value="5">
                                                                                        <label
                                                                                            class="star-rating__ico fa fa-star-o"
                                                                                            for="star-rating-5"
                                                                                            title="5 out of 5 stars"></label>
                                                                                        <input class="star-rating__input"
                                                                                            id="star-rating-4" type="radio"
                                                                                            name="rate" value="4">
                                                                                        <label
                                                                                            class="star-rating__ico fa fa-star-o"
                                                                                            for="star-rating-4"
                                                                                            title="4 out of 5 stars"></label>
                                                                                        <input class="star-rating__input"
                                                                                            id="star-rating-3" type="radio"
                                                                                            name="rate" value="3">
                                                                                        <label
                                                                                            class="star-rating__ico fa fa-star-o"
                                                                                            for="star-rating-3"
                                                                                            title="3 out of 5 stars"></label>
                                                                                        <input class="star-rating__input"
                                                                                            id="star-rating-2" type="radio"
                                                                                            name="rate" value="2">
                                                                                        <label
                                                                                            class="star-rating__ico fa fa-star-o"
                                                                                            for="star-rating-2"
                                                                                            title="2 out of 5 stars"></label>
                                                                                        <input class="star-rating__input"
                                                                                            id="star-rating-1" type="radio"
                                                                                            name="rate" value="1">
                                                                                        <label
                                                                                            class="star-rating__ico fa fa-star-o"
                                                                                            for="star-rating-1"
                                                                                            title="1 out of 5 stars"></label>
                                                                                        @error('rate')
                                                                                            <span
                                                                                                class="text-danger">{{ $message }}</span>
                                                                                        @enderror
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-12 col-12">
                                                                            <div class="form-group">
                                                                                <label>Viết đánh giá</label>
                                                                                <textarea name="review" rows="6" placeholder=""></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-12 col-12">
                                                                            <div class="form-group button5">
                                                                                <button type="submit" class="btn">Đánh
                                                                                    giá</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            @else
                                                                <p class="text-center p-5">
                                                                    Bạn cần phải <a href="{{ route('login.form') }}"
                                                                        style="color:rgb(54, 54, 204)">Đăng nhập</a> hoặc <a
                                                                        style="color:blue"
                                                                        href="{{ route('register.form') }}">Đăng ký</a>

                                                                </p>
                                                                <!--/ End Form -->
                                                            @endauth
                                                        </div>
                                                    </div>

                                                    <div class="ratting-main">
                                                        <div class="avg-ratting ">
                                                            @if ($product_detail->getReview && $product_detail->getReview->count() > 0)
                                                                <h4>
                                                                    {{ ceil($product_detail->getReview->avg('rate')) }}
                                                                    <span class="stars">
                                                                        @for ($i = 1; $i <= 5; $i++)
                                                                            @if ($product_detail->getReview->avg('rate') >= $i)
                                                                                <i class="fa fa-star text-warning"></i>
                                                                            @else
                                                                                <i class="fa fa-star-o text-muted"></i>
                                                                            @endif
                                                                        @endfor
                                                                    </span>
                                                                </h4>
                                                                <span class="text-muted">(Tổng quan)</span>
                                                                <br>
                                                                <span>Dựa trên
                                                                    <strong>{{ $product_detail->getReview->count() }}</strong>
                                                                    bình luận</span>
                                                            @else
                                                                <h4 class="text-muted">Chưa có bình luận</h4>
                                                            @endif
                                                        </div>


                                                        @foreach ($product_detail['getReview'] as $data)
                                                            <!-- Single Rating -->
                                                            <div class="single-rating">
                                                                <div class="rating-author">
                                                                    @if ($data->user_info['photo'])
                                                                        <img src="{{ $data->user_info['photo'] }}"
                                                                            alt="{{ $data->user_info['photo'] }}">
                                                                    @else
                                                                        <img src="{{ asset('backend/img/avatar.png') }}"
                                                                            alt="Profile.jpg">
                                                                    @endif
                                                                </div>
                                                                <div class="rating-des">
                                                                    <h6>{{ $data->user_info['name'] }}</h6>
                                                                    <div class="ratings">

                                                                        <ul class="rating">
                                                                            @for ($i = 1; $i <= 5; $i++)
                                                                                @if ($data->rate >= $i)
                                                                                    <li><i class="fa fa-star"></i></li>
                                                                                @else
                                                                                    <li><i class="fa fa-star-o"></i></li>
                                                                                @endif
                                                                            @endfor
                                                                        </ul>
                                                                        <div class="rate-count">
                                                                            (<span>{{ $data->rate }}</span>)</div>
                                                                    </div>
                                                                    <p>{{ $data->review }}</p>
                                                                </div>
                                                            </div>
                                                            <!--/ End Single Rating -->
                                                        @endforeach
                                                    </div>

                                                    <!--/ End Review -->

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/ End Reviews Tab -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/ End Shop Single -->

    <!-- Start Most Popular -->
    <div class="product-area most-popular related-product section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>Sản Phẩm Liên Quan</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                {{-- Duyệt qua các sản phẩm liên quan --}}
                @foreach ($product_detail->rel_prods as $data)
                    @if ($data->id !== $product_detail->id)
                        <div class="col-sm-6 col-md-4 col-lg-3 p-b-35"> <!-- Hiển thị 4 sản phẩm trên 1 hàng -->
                            <div class="single-product">
                                <div class="product-img">
                                    <a href="{{ route('product-detail', $data->slug) }}">
                                        @php
                                            $photo = explode(',', $data->photo);
                                        @endphp
                                        <img class="default-img" src="{{ $photo[0] }}" alt="{{ $data->title }}">
                                        <img class="hover-img" src="{{ $photo[0] }}" alt="{{ $data->title }}">
                                        @if ($data->discount > 0)
                                            <span class="price-dec">{{ $data->discount }}% Off</span>
                                        @endif
                                    </a>
                                    <div class="button-head">
                                        <div class="product-action">
                                            <a data-toggle="modal" data-target="#{{ $product_detail->id }}"
                                                title="Quick View" href="#"><i class=" ti-eye"></i><span>Xem qua
                                                    sản phẩm</span></a>
                                            <a title="Wishlist"
                                                href="{{ route('add-to-wishlist', $product_detail->slug) }}"><i
                                                    class=" ti-heart "></i><span>Thêm vào danh sách yêu
                                                    thích</span></a>
                                        </div>
                                        <div class="product-action-2">
                                            <a title="Add to cart"
                                                href="{{ route('add-to-cart', $product_detail->slug) }}">Thêm
                                                vào giỏ
                                                hàng</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-content">
                                    <h3><a href="{{ route('product-detail', $data->slug) }}">{{ $data->title }}</a></h3>
                                    <div class="product-price">
                                        @php
                                            $after_discount = $data->price - ($data->price * $data->discount) / 100;
                                        @endphp
                                        <span>{{ number_format($after_discount, 0) }} đ</span>
                                        @if ($data->discount > 0)
                                            <span class="old">{{ number_format($data->price, 0) }} đ</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    <!-- End Most Popular Area -->


    <!-- Modal -->


@endsection
@push('styles')
    <style>
        /* Rating */
        .rating_box {
            display: inline-flex;
        }

        .star-rating {
            font-size: 0;
            padding-left: 10px;
            padding-right: 10px;
        }

        .star-rating__wrap {
            display: inline-block;
            font-size: 1rem;
        }

        .star-rating__wrap:after {
            content: "";
            display: table;
            clear: both;
        }

        .star-rating__ico {
            float: right;
            padding-left: 2px;
            cursor: pointer;
            color: #F7941D;
            font-size: 16px;
            margin-top: 5px;
        }

        .star-rating__ico:last-child {
            padding-left: 0;
        }

        .star-rating__input {
            display: none;
            float: right;
            padding-left: 2px;
            cursor: pointer;
            color: #F7941D;
            font-size: 16px;
            margin-top: 5px;

        }

        .star-rating__ico:hover:before,
        .star-rating__ico:hover~.star-rating__ico:before,
        .star-rating__input:checked~.star-rating__ico:before {
            content: "\F005";
        }

        .single-des .description-content {
            max-height: 2000px;
            /* Hiển thị phần mô tả cao hơn */
            overflow: hidden;
            transition: max-height 0.3s ease;
        }

        .single-des.expanded .description-content {
            max-height: none;
            /* Mở rộng khi có class 'expanded' */
        }

        .toggle-button {
            background-color: #E0E0E0;
            /* Màu nền xám nhạt */
            color: #333333;
            /* Màu chữ đen đậm */
            font-size: 24px;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 15px;
            text-align: center;
            width: 100%;
            /* Căn giữa chữ */
            transition: all 0.3s ease;
        }

        .toggle-button:hover {
            background-color: #BDBDBD;
            /* Xám đậm hơn khi hover */
            color: #000;
            /* Chữ đen hoàn toàn khi hover */
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            /* Đổ bóng nhẹ */
        }
    </style>
@endpush
@push('scripts')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const toggleButton = document.querySelector(".toggle-button");
            const descriptionContainer = document.querySelector(".single-des");

            toggleButton.addEventListener("click", function() {
                descriptionContainer.classList.toggle("expanded");
                if (descriptionContainer.classList.contains("expanded")) {
                    toggleButton.textContent = "Thu gọn ▲";
                } else {
                    toggleButton.textContent = "Xem thêm ▼";
                }
            });
        });
    </script>
@endpush
