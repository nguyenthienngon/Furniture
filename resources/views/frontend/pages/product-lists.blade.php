@extends('frontend.layouts.master')

@section('title', 'Artisan || Sản Phẩm')

@section('main-content')

    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{ route('home') }}">Trang Chủ<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="javascript:void(0);">Sản Phẩm</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->
    <form action="{{ route('shop.filter') }}" method="POST">
        @csrf
        <input type="hidden" name="view" value="{{ request()->input('view', 'list') }}">
        <!-- Product Style 1 -->
        <section class="product-area shop-sidebar shop-list shop section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="shop-sidebar">
                            <!-- Single Widget -->
                            <div class="single-widget category">
                                <h3 class="title">Danh Mục Sản Phẩm</h3>
                                <ul class="categor-list">
                                    @php
                                        // $category = new Category();
                                        $menu = App\Models\Category::getAllParentWithChild();
                                    @endphp
                                    @if ($menu)
                                        <li>
                                            @foreach ($menu as $cat_info)
                                                @if ($cat_info->child_cat->count() > 0)
                                        <li><a href="{{ route('product-cat', $cat_info->slug) }}">{{ $cat_info->title }}</a>
                                            <ul>
                                                @foreach ($cat_info->child_cat as $sub_menu)
                                                    <li><a
                                                            href="{{ route('product-sub-cat', [$cat_info->slug, $sub_menu->slug]) }}">{{ $sub_menu->title }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    @else
                                        <li><a href="{{ route('product-cat', $cat_info->slug) }}">{{ $cat_info->title }}</a>
                                        </li>
                                    @endif
                                    @endforeach
                                    </li>
                                    @endif
                                    {{-- @foreach (Helper::productCategoryList('products') as $cat)
                                            @if ($cat->is_parent == 1)
												<li><a href="{{route('product-cat',$cat->slug)}}">{{$cat->title}}</a></li>
											@endif
                                        @endforeach --}}
                                </ul>
                            </div>
                            <!--/ End Single Widget -->
                            <!-- Shop By Price -->
                            <div class="single-widget range">
                                <h3 class="title">Lọc Theo Giá</h3>
                                <div class="price-filter">
                                    <div class="price-filter-inner">
                                        @php
                                            $max = DB::table('products')->max('price');
                                        @endphp
                                        <div class="product_filter">
                                            <span>Hoặc Chọn Khoảng Giá:</span>
                                            <div class="checkbox-list">
                                                @foreach (['0-2000000' => 'Dưới 2.000.000', '2000000-5000000' => '2.000.000 - 5.000.000', '5000000-10000000' => '5.000.000 - 10.000.000', '10000000-' . $max => 'Trên 10.000.000'] as $value => $label)
                                                    <label>
                                                        <input type="checkbox" name="price_range[]"
                                                            value="{{ $value }}"
                                                            @if (isset($data['price_range']) && in_array($value, $data['price_range'])) checked @endif>
                                                        {{ $label }}
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                        <button type="submit" class="filter_button">Lọc</button>
                                    </div>
                                </div>
                            </div>
                            <!--/ End Shop By Price -->
                            <!-- Single Widget -->

                            <!--/ End Single Widget -->
                            <!-- Single Widget -->
                            <div class="single-widget category">
                                <h3 class="title">Thương hiệu</h3>
                                <ul class="categor-list">
                                    @php
                                        $brands = DB::table('brands')
                                            ->orderBy('title', 'ASC')
                                            ->where('status', 'active')
                                            ->get();
                                    @endphp
                                    @foreach ($brands as $brand)
                                        <li><a href="#">{{ $brand->title }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <!--/ End Single Widget -->
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-8 col-12">
                        <div class="row">
                            <div class="col-12">
                                <!-- Shop Top -->
                                <div class="shop-top">
                                    <div class="shop-shorter">
                                        <div class="single-shorter">
                                            <label>Hiển thị :</label>
                                            <select>
                                                <option value="">Mặc định</option>
                                                <option value="9">09
                                                </option>
                                                <option value="15">15
                                                </option>
                                                <option value="21">21
                                                </option>
                                                <option value="30">30
                                                </option>
                                            </select>
                                        </div>
                                        <div class="single-shorter">
                                            <label>Xếp theo :</label>
                                            <select class='sortBy' name='sortBy'
                                                onchange="window.location.href='{{ route('product-lists') }}?sortBy=' + this.value;">
                                                <option value="">Mặc định</option>
                                                <option value="title" @if (!empty($_GET['sortBy']) && $_GET['sortBy'] == 'title') selected @endif>Tên
                                                </option>
                                                <option value="price" @if (!empty($_GET['sortBy']) && $_GET['sortBy'] == 'price') selected @endif>Giá
                                                </option>
                                                <option value="category" @if (!empty($_GET['sortBy']) && $_GET['sortBy'] == 'category') selected @endif>
                                                    Danh mục</option>
                                                <option value="brand" @if (!empty($_GET['sortBy']) && $_GET['sortBy'] == 'brand') selected @endif>
                                                    Thương hiệu</option>
                                            </select>
                                        </div>
                                    </div>
                                    <ul class="view-mode">
                                        <li><a href="{{ route('product-grids') }}"><i class="fa fa-th-large"></i></a></li>
                                        <li class="active"><a href="javascript:void(0)"><i class="fa fa-th-list"></i></a>
                                        </li>
                                    </ul>
                                </div>
                                <!--/ End Shop Top -->
                            </div>
                        </div>
                        <div class="row">
                            @if (count($products))
                                @foreach ($products as $product)
                                    {{-- {{$product}} --}}
                                    <!-- Start Single List -->
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-6 col-sm-6">
                                                <div class="single-product">
                                                    <div class="product-img">
                                                        <a href="{{ route('product-detail', $product->slug) }}">
                                                            @php
                                                                $photo = explode(',', $product->photo);
                                                            @endphp
                                                            <img class="default-img" src="{{ $photo[0] }}"
                                                                alt="{{ $photo[0] }}">
                                                            <img class="hover-img" src="{{ $photo[0] }}"
                                                                alt="{{ $photo[0] }}">
                                                        </a>
                                                        <div class="button-head">
                                                            <div class="product-action">
                                                                <a data-toggle="modal" data-target="#{{ $product->id }}"
                                                                    title="Quick View" href="#"><i
                                                                        class=" ti-eye"></i><span>Mua Nhanh</span></a>
                                                                <a title="Wishlist"
                                                                    href="{{ route('add-to-wishlist', $product->slug) }}"
                                                                    class="wishlist" data-id="{{ $product->id }}"><i
                                                                        class=" ti-heart "></i><span>Thêm vào danh sách yêu
                                                                        thích</span></a>
                                                            </div>
                                                            <div class="product-action-2">
                                                                <a title="Add to cart"
                                                                    href="{{ route('add-to-cart', $product->slug) }}">Thêm
                                                                    vào giỏ hàng</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-8 col-md-6 col-12">
                                                <div class="list-content">
                                                    <div class="product-content">
                                                        <div class="product-price">
                                                            @php
                                                                $after_discount =
                                                                    $product->price -
                                                                    ($product->price * $product->discount) / 100;
                                                            @endphp

                                                            <span>{{ number_format($after_discount, 0) }}đ</span>
                                                            @if ($product->discount > 0)
                                                                <del>{{ number_format($product->price, 0) }}đ</del>
                                                            @endif

                                                        </div>
                                                        <h3 class="title"><a
                                                                href="{{ route('product-detail', $product->slug) }}">{{ $product->title }}</a>
                                                        </h3>
                                                        {{-- <p>{!! html_entity_decode($product->summary) !!}</p> --}}
                                                    </div>
                                                    <p class="des pt-2">{!! html_entity_decode($product->summary) !!}</p>
                                                    <a href="javascript:void(0)" class="btn cart"
                                                        data-id="{{ $product->id }}">Mua Ngay!</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Single List -->
                                @endforeach
                            @else
                                <h4 class="text-warning" style="margin:100px auto;">Không Có Sản Phẩm Nào.</h4>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-md-12 justify-content-center d-flex">
                                {{-- {{$products->appends($_GET)->links()}}  --}}
                            </div>
                        </div>



                        <div class="row">
                            <div class="col-md-12 justify-content-center d-flex">
                                {{ $products->appends($_GET)->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--/ End Product Style 1  -->
    </form>

    <!-- Modal end -->
@endsection
@push('styles')
    <style>
        .pagination {
            display: inline-flex;
        }

        .filter_button {
            /* height:20px; */
            text-align: center;
            background: #F7941D;
            padding: 8px 16px;
            margin-top: 10px;
            color: white;
        }

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
    </style>
@endpush
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
@endpush
