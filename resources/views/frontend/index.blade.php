@extends('frontend.layouts.master')
@section('title',
    'Artisan
    || Trang Chủ')
@section('main-content')
    <!-- Slider Area -->
    @if (count($banners) > 0)
        <section id="Gslider" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                @foreach ($banners as $key => $banner)
                    <li data-target="#Gslider" data-slide-to="{{ $key }}" class="{{ $key == 0 ? 'active' : '' }}">
                    </li>
                @endforeach
            </ol>
            <div class="carousel-inner" role="listbox">
                @foreach ($banners as $key => $banner)
                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                        <a href="{{ route('product-grids') }}"> <!-- Thêm link vào ảnh -->
                            <img class="d-block w-100 banner-img" src="{{ $banner->photo }}" alt="Slide">
                        </a>
                    </div>
                @endforeach
            </div>
            <a class="carousel-control-prev" href="#Gslider" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#Gslider" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </section>
    @endif

    <!--/ End Slider Area -->

    <!-- Start Small Banner  -->
    {{-- <section class="small-banner section"> --}}
    {{--    <div class="container-fluid"> --}}
    {{--        <div class="row"> --}}
    {{--            @php --}}
    {{--            $category_lists=DB::table('categories')->where('status','active')->limit(10)->get(); --}}
    {{--            @endphp --}}
    {{--            @if ($category_lists) --}}
    {{--                @foreach ($category_lists as $cat) --}}
    {{--                    @if ($cat->is_parent == 1) --}}
    {{--                        <!-- Single Banner  --> --}}
    {{--                        <div class="col-lg-3 col-md-6 col-12"> --}}
    {{--                            <div class="single-banner"> --}}
    {{--                                @if ($cat->photo) --}}
    {{--                                    <img src="{{$cat->photo}}" alt="{{$cat->photo}}"> --}}
    {{--                                @else --}}
    {{--                                    <img src="https://via.placeholder.com/600x370" alt="#"> --}}
    {{--                                @endif --}}
    {{--                                <div class="content"> --}}
    {{--                                    <h3>{{$cat->title}}</h3> --}}
    {{--                                        <a href="{{route('product-cat',$cat->slug)}}">Khám phá ngay</a> --}}
    {{--                                </div> --}}
    {{--                            </div> --}}
    {{--                        </div> --}}
    {{--                    @endif --}}
    {{--                    <!-- /End Single Banner  --> --}}
    {{--                @endforeach --}}
    {{--            @endif --}}
    {{--        </div> --}}
    {{--    </div> --}}
    {{-- </section> --}}
    <!-- End Small Banner -->

    <!-- Start Product Area -->
    <div class="product-area section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>Mẫu Thịnh Hành</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="product-info">
                        <div class="nav-main">
                            <!-- Tab Nav -->
                            <ul class="nav nav-tabs filter-tope-group" id="myTab" role="tablist">
                                @php
                                    $categories = DB::table('categories')
                                        ->where('status', 'active')
                                        ->where('is_parent', 1)
                                        ->get();
                                    // dd($categories);
                                @endphp
                                @if ($categories)
                                    <button class="btn" style="background:black"data-filter="*">
                                        Tất Cả
                                    </button>
                                    @foreach ($categories as $key => $cat)
                                        <button class="btn"
                                            style="background:none;color:black;"data-filter=".{{ $cat->id }}">
                                            {{ $cat->title }}
                                        </button>
                                    @endforeach
                                @endif
                            </ul>
                            <!--/ End Tab Nav -->
                        </div>
                        <div class="tab-content isotope-grid" id="myTabContent">
                            <!-- Start Single Tab -->
                            @if ($product_lists)
                                @foreach ($product_lists as $key => $product)
                                    <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item {{ $product->cat_id }}">
                                        <div class="single-product">
                                            <div class="product-img">
                                                <a href="{{ route('product-detail', $product->slug) }}">
                                                    @php
                                                        $photo = explode(',', $product->photo);
                                                        // dd($photo);
                                                    @endphp
                                                    <img class="default-img" src="{{ $photo[0] }}"
                                                        alt="{{ $product->name }}">
                                                    <img class="hover-img" src="{{ $photo[0] }}"
                                                        alt="{{ $product->name }}">

                                                    {{-- @if ($product->stock <= 0)
                                                        <span class="out-of-stock">Sold out</span>
                                                    @elseif($product->condition == 'new')
                                                        <span class="new">New</span>
                                                    @elseif($product->condition == 'hot')
                                                        <span class="hot">Hot</span>
                                                        {{-- @else
                                                        <span class="price-dec">{{ $product->discount }}% Off</span> -
                                                    @endif --}}
                                                </a>

                                                <div class="button-head">
                                                    <div class="product-action">
                                                        <a data-toggle="modal" data-target="#{{ $product->id }}"
                                                            title="Quick View" href="#"><i
                                                                class=" ti-eye"></i><span>Xem qua sản phẩm</span></a>
                                                        <a title="Wishlist"
                                                            href="{{ route('add-to-wishlist', $product->slug) }}"><i
                                                                class=" ti-heart "></i><span>Thêm vào danh sách yêu
                                                                thích</span></a>
                                                    </div>
                                                    <div class="product-action-2">
                                                        <a title="Add to cart"
                                                            href="{{ route('add-to-cart', $product->slug) }}">Thêm vào giỏ
                                                            hàng</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="product-content">
                                                <h3><a
                                                        href="{{ route('product-detail', $product->slug) }}">{{ $product->title }}</a>
                                                </h3>
                                                <div class="product-price">
                                                    @php
                                                        // Tính toán giá sau khi giảm giá
                                                        $after_discount =
                                                            $product->price -
                                                            ($product->price * $product->discount) / 100;
                                                    @endphp
                                                    <span>{{ number_format($after_discount, 0) }} đ</span>
                                                    @if ($product->discount > 0)
                                                        <!-- Kiểm tra nếu discount lớn hơn 0 -->
                                                        <span class="old">{{ number_format($product->price, 0) }}
                                                            đ</span>
                                                    @endif
                                                </div>




                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <!--/ End Single Tab -->
                            @endif

                            <!--/ End Single Tab -->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Start Most Popular -->
    <div class="product-area most-popular section" style="padding-top: 0px">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title" style="margin-bottom: 0px">
                        <h2>Mẫu Mới Nhất</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="owl-carousel popular-slider">
                        @php
                            use Illuminate\Support\Facades\DB;

                            // Lấy 10 sản phẩm mới nhất (theo thời gian thêm vào)
                            $latest_products = DB::table('products')
                                ->where('status', 'active')
                                ->orderBy('created_at', 'DESC')
                                ->limit(10)
                                ->get();

                            // Cập nhật toàn bộ sản phẩm về "default" trước
                            DB::table('products')
                                ->where('condition', 'new')
                                ->update(['condition' => 'default']);

                            // Đặt 10 sản phẩm mới nhất thành "new"
                            DB::table('products')
                                ->whereIn('id', $latest_products->pluck('id'))
                                ->update(['condition' => 'new']);

                            // Lấy lại danh sách 10 sản phẩm "new" sau khi cập nhật
                            $latest_products = DB::table('products')
                                ->where('condition', 'new')
                                ->where('status', 'active')
                                ->orderBy('created_at', 'DESC')
                                ->limit(10)
                                ->get();
                        @endphp

                        @foreach ($latest_products as $product)
                            <div class="single-product">
                                <div class="product-img">
                                    <a href="{{ route('product-detail', $product->slug) }}">
                                        @php
                                            $photo = explode(',', $product->photo);
                                        @endphp
                                        <img class="default-img" src="{{ $photo[0] }}" alt="{{ $photo[0] }}">
                                        <img class="hover-img" src="{{ $photo[0] }}" alt="{{ $photo[0] }}">
                                        <span class="new">New</span>
                                    </a>
                                    <div class="button-head">
                                        <div class="product-action">
                                            <a data-toggle="modal" data-target="#{{ $product->id }}" title="Quick View"
                                                href="#"><i class="ti-eye"></i><span>Xem qua sản phẩm</span></a>
                                            <a title="Wishlist" href="{{ route('add-to-wishlist', $product->slug) }}">
                                                <i class="ti-heart"></i><span>Thêm vào danh sách yêu thích</span></a>
                                        </div>
                                        <div class="product-action-2">
                                            <a href="{{ route('add-to-cart', $product->slug) }}">Thêm vào giỏ hàng</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-content">
                                    <h3><a href="{{ route('product-detail', $product->slug) }}">{{ $product->title }}</a>
                                    </h3>
                                    <div class="product-price">
                                        @php
                                            // Tính toán giá sau khi giảm giá
                                            $after_discount =
                                                $product->price - ($product->price * $product->discount) / 100;
                                        @endphp
                                        <span>{{ number_format($after_discount, 0) }} đ</span>
                                        @if ($product->discount > 0)
                                            <span class="old">{{ number_format($product->price, 0) }} đ</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- End Most Popular Area -->

    <!-- Start Shop Home List (Thay đổi để hiển thị sản phẩm bán chạy) -->
    <section class="shop-home-list section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-12">
                    <div class="row">
                        <div class="col-12">
                            <div class="section-title" style="margin-bottom: 0px">
                                <h2>Flash Sale – Deal Hot Trong Ngày!</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @php
                            // Lấy 8 sản phẩm có mức giảm giá cao nhất
                            $products = DB::table('products')
                                ->where('status', 'active')
                                ->orderByDesc('discount')
                                ->limit(9)
                                ->get();
                        @endphp

                        @if (!empty($products) && count($products) > 0)
                            @foreach ($products as $product)
                                <div class="col-md-4">
                                    <div class="single-list">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="list-image overlay">
                                                    @php
                                                        $photo = explode(',', $product->photo);
                                                    @endphp
                                                    <img src="{{ $photo[0] }}" alt="{{ $product->title }}">
                                                    <a href="{{ route('add-to-cart', $product->slug) }}"
                                                        class="buy"><i class="fa fa-shopping-bag"></i></a>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12 no-padding">
                                                <div class="content">
                                                    <h4 class="title">
                                                        <a
                                                            href="{{ route('product-detail', $product->slug) }}">{{ $product->title }}</a>
                                                    </h4>
                                                    <p class="price with-discount">Giảm
                                                        {{ number_format($product->discount, 0) }} %</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p class="text-center">Không có sản phẩm nào.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- End Shop Home List --}}

    <!-- Start Shop Blog  -->
    <section class="shop-blog section" style="padding-top: 0px; padding-bottom: 50px">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>Bài Viết</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @if ($posts)
                    @foreach ($posts as $post)
                        <div class="col-lg-4 col-md-6 col-12">
                            <!-- Start Single Blog  -->
                            <div class="shop-single-blog">
                                <img src="{{ $post->photo }}" alt="{{ $post->photo }}">
                                <div class="content">
                                    <p class="date">{{ $post->created_at->format('d M , Y. D') }}</p>
                                    <a href="{{ route('blog.detail', $post->slug) }}"
                                        class="title">{{ $post->title }}</a>
                                    <a href="{{ route('blog.detail', $post->slug) }}" class="more-btn"
                                        style="text-decoration: underline">Xem Thêm</a>
                                </div>
                            </div>
                            <!-- End Single Blog  -->
                        </div>
                    @endforeach
                @endif

            </div>
        </div>
    </section>
    <!-- End Shop Blog  -->

    <!-- Start Shop Services Area -->
    <section class="shop-services section home" style="padding-top: 50px;padding-bottom: 50px; background-color: #eaeaea">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Start Single Service -->
                    <div class="single-service">
                        <i class="ti-rocket"></i>
                        <h4>Miễn Phí Giao Hàng</h4>
                        <p>Cho đơn hàng trên 1.000.000 đ</p>
                    </div>
                    <!-- End Single Service -->
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Start Single Service -->
                    <div class="single-service">
                        <i class="ti-reload"></i>
                        <h4>Miễn Phí Hoàn Trả</h4>
                        <p>Trong vòng 30 ngày</p>
                    </div>
                    <!-- End Single Service -->
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Start Single Service -->
                    <div class="single-service">
                        <i class="ti-lock"></i>
                        <h4>Bảo Mật Thanh Toán</h4>
                        <p>100% Bảo Mật Thanh Toán</p>
                    </div>
                    <!-- End Single Service -->
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Start Single Service -->
                    <div class="single-service">
                        <i class="ti-tag"></i>
                        <h4>Giá Tốt Nhất</h4>
                        <p>Đảm Bảo Giá Tốt Nhất</p>
                    </div>
                    <!-- End Single Service -->
                </div>
            </div>
        </div>
    </section>
    <!-- End Shop Services Area -->

    @include('frontend.layouts.newsletter')

    <!-- Modal -->
    @if ($product_lists)
        @foreach ($product_lists as $key => $product)
            <div class="modal fade" id="{{ $product->id }}" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    class="ti-close" aria-hidden="true"></span></button>
                        </div>
                        <div class="modal-body">
                            <div class="row no-gutters">
                                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                    <!-- Product Slider -->
                                    <div class="product-gallery">
                                        <div class="quickview-slider-active">
                                            @php
                                                $photo = explode(',', $product->photo);
                                                // dd($photo);
                                            @endphp
                                            @foreach ($photo as $data)
                                                <div class="single-slider">
                                                    <img src="{{ $data }}" alt="{{ $data }}">
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <!-- End Product slider -->
                                </div>
                                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                    <div class="quickview-content">
                                        <h2>{{ $product->title }}</h2>
                                        <div class="quickview-ratting-review">
                                            <div class="quickview-ratting-wrap">
                                                <div class="quickview-ratting">


                                                </div>
                                                <a href="#" class="total-review">({{ rand(1, 100) }}) Đánh
                                                    Giá</a>

                                            </div>
                                            <div class="quickview-stock">
                                                @if ($product->stock > 0)
                                                    <span><i class="fa fa-check-circle-o"></i> {{ $product->stock }} sản
                                                        phẩm trong kho</span>
                                                @else
                                                    <span><i class="fa fa-times-circle-o text-danger"></i>
                                                        {{ $product->stock }} Hết hàng</span>
                                                @endif
                                            </div>
                                        </div>
                                        @php
                                            $after_discount =
                                                $product->price - ($product->price * $product->discount) / 100;
                                        @endphp
                                        <h3><small><del class="text-muted">{{ number_format($product->price, 0) }}
                                                    đ</del></small> {{ number_format($after_discount, 0) }} đ </h3>
                                        <div class="quickview-peragraph">
                                            <p>{!! html_entity_decode($product->summary) !!}</p>
                                        </div>

                                        <form action="{{ route('single-add-to-cart') }}" method="POST" class="mt-4">
                                            @csrf
                                            <div class="quantity">
                                                <!-- Input Order -->
                                                <div class="input-group">
                                                    <div class="button minus">
                                                        <button type="button" class="btn btn-primary btn-number"
                                                            disabled="disabled" data-type="minus" data-field="quant[1]">
                                                            <i class="ti-minus"></i>
                                                        </button>
                                                    </div>
                                                    <input type="hidden" name="slug" value="{{ $product->slug }}">
                                                    <input type="text" name="quant[1]" class="input-number"
                                                        data-min="1" data-max="1000000" value="1">
                                                    <div class="button plus">
                                                        <button type="button" class="btn btn-primary btn-number"
                                                            data-type="plus" data-field="quant[1]">
                                                            <i class="ti-plus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <!--/ End Input Order -->
                                            </div>
                                            <div class="add-to-cart">
                                                <button type="submit" class="btn">Thêm vào giỏ hàng</button>
                                                <a href="{{ route('add-to-wishlist', $product->slug) }}"
                                                    class="btn min"><i class="ti-heart"></i></a>
                                            </div>
                                        </form>
                                        <div class="default-social">
                                            <!-- ShareThis BEGIN -->
                                            <div class="sharethis-inline-share-buttons"></div><!-- ShareThis END -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
    <!-- Modal end -->
@endsection

@push('styles')
    <script type='text/javascript'
        src='https://platform-api.sharethis.com/js/sharethis.js#property=5f2e5abf393162001291e431&product=inline-share-buttons'
        async='async'></script>
    <script type='text/javascript'
        src='https://platform-api.sharethis.com/js/sharethis.js#property=5f2e5abf393162001291e431&product=inline-share-buttons'
        async='async'></script>
    <style>
        /* Banner Sliding */
        #Gslider .carousel-inner {
            background: #000;
            /* Xóa màu đen nếu ảnh đã đầy */
            color: black;
            height: auto;
            /* Chiều cao tự động theo ảnh */
        }

        #Gslider .carousel-item img {
            width: 80%;
            height: 800vh;
            /* Tự động căn chỉnh theo chiều cao màn hình */
            max-height: 500px;
            /* Giới hạn chiều cao tối đa */
            object-fit: cover;
            /* Đảm bảo ảnh không bị méo và lấp đầy */
        }

        #Gslider .carousel-inner .carousel-caption {
            bottom: 33%;
        }

        #Gslider .carousel-inner .carousel-caption h1 {
            font-size: 45px;
            font-weight: bold;
            line-height: 100%;
            color: #F7941D;
        }

        #Gslider .carousel-inner .carousel-caption p {
            font-size: 18px;
            color: black;
            margin: 20px 0;
        }

        #Gslider .carousel-indicators {
            bottom: 70px;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>
        /*==================================================================
                                                                                                                                                                                                                                                                                                                                                    [ Isotope ]*/
        var $topeContainer = $('.isotope-grid');
        var $filter = $('.filter-tope-group');

        // filter items on button click
        $filter.each(function() {
            $filter.on('click', 'button', function() {
                var filterValue = $(this).attr('data-filter');
                $topeContainer.isotope({
                    filter: filterValue
                });
            });

        });

        // init Isotope
        $(window).on('load', function() {
            var $grid = $topeContainer.each(function() {
                $(this).isotope({
                    itemSelector: '.isotope-item',
                    layoutMode: 'fitRows',
                    percentPosition: true,
                    animationEngine: 'best-available',
                    masonry: {
                        columnWidth: '.isotope-item'
                    }
                });
            });
        });




        var isotopeButton = $('.filter-tope-group button');

        $(isotopeButton).each(function() {
            $(this).on('click', function() {
                for (var i = 0; i < isotopeButton.length; i++) {
                    $(isotopeButton[i]).removeClass('how-active1');
                }

                $(this).addClass('how-active1');
            });
        });
    </script>
    {{-- <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: "{{ session('success') }}",
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: "{{ session('error') }}",
            });
        @endif
    </script> --}}

    <script>
        function cancelFullScreen(el) {
            var requestMethod = el.cancelFullScreen || el.webkitCancelFullScreen || el.mozCancelFullScreen || el
                .exitFullscreen;
            if (requestMethod) { // cancel full screen.
                requestMethod.call(el);
            } else if (typeof window.ActiveXObject !== "undefined") { // Older IE.
                var wscript = new ActiveXObject("WScript.Shell");
                if (wscript !== null) {
                    wscript.SendKeys("{F11}");
                }
            }
        }

        function requestFullScreen(el) {
            // Supports most browsers and their versions.
            var requestMethod = el.requestFullScreen || el.webkitRequestFullScreen || el.mozRequestFullScreen || el
                .msRequestFullscreen;

            if (requestMethod) { // Native full screen.
                requestMethod.call(el);
            } else if (typeof window.ActiveXObject !== "undefined") { // Older IE.
                var wscript = new ActiveXObject("WScript.Shell");
                if (wscript !== null) {
                    wscript.SendKeys("{F11}");
                }
            }
            return false
        }
    </script>
@endpush
