@extends('frontend.layouts.master')

@section('title', 'Artisan || Sản Phẩm')

@section('main-content')

    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="index1.html">Trang Chủ<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="blog-single.html">Sản Phẩm</a></li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Product Style -->
    <form action="{{ route('shop.filter') }}" method="POST">
        @csrf
        <input type="hidden" name="view" value="{{ request()->input('view', 'grid') }}">
        <section class="product-area shop-sidebar shop section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="shop-sidebar">
                            <!-- Single Widget -->
                            <div class="single-widget category">
                                <h3 class="title">Danh Mục Sản Phẩm</h3>
                                <ul class="categor-list">
                                    @php
                                        $menu = App\Models\Category::getAllParentWithChild();
                                    @endphp
                                    @if ($menu)
                                        <li>
                                            @foreach ($menu as $cat_info)
                                                @if ($cat_info->child_cat->count() > 0)
                                        <li>
                                            <a href="{{ route('product-cat', $cat_info->slug) }}">{{ $cat_info->title }}</a>
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
                                </ul>
                            </div>
                            <!--/ End Single Widget -->

                            <!-- Lọc Theo Giá -->
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
                            <!--/ End Lọc Theo Giá -->
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
                                                <option value="9">09</option>
                                                <option value="15">15</option>
                                                <option value="21">21</option>
                                                <option value="30">30</option>
                                            </select>
                                        </div>
                                        <div class="single-shorter">
                                            <label>Xếp theo :</label>
                                            <select class='sortBy' name='sortBy'
                                                onchange="window.location.href='{{ route('product-grids') }}?sortBy=' + this.value;">
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
                                        <li class="active"><a href="javascript:void(0)"><i class="fa fa-th-large"></i></a>
                                        </li>
                                        <li><a href="{{ route('product-lists') }}"><i class="fa fa-th-list"></i></a></li>
                                    </ul>
                                </div>
                                <!--/ End Shop Top -->
                            </div>
                        </div>

                        <div class="row">
                            {{-- Hiển thị sản phẩm --}}
                            @if (count($products) > 0)
                                @foreach ($products as $product)
                                    <div class="col-lg-4 col-md-6 col-12">
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
                                                    @if ($product->discount)
                                                        <span class="price-dec">{{ $product->discount }} % Off</span>
                                                    @endif
                                                </a>
                                                <div class="button-head">
                                                    <div class="product-action">
                                                        <a href="{{ route('product-detail', $product->slug) }}"><i
                                                                class="ti-eye"></i><span>Mua ngay</span></a>
                                                        <a title="Wishlist"
                                                            href="{{ route('add-to-wishlist', $product->slug) }}"
                                                            class="wishlist" data-id="{{ $product->id }}"><i
                                                                class="ti-heart"></i><span>Thêm vào danh sách yêu
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
                                                @php
                                                    $after_discount = $product->price;
                                                    if ($product->discount != 0) {
                                                        $after_discount =
                                                            $product->price -
                                                            ($product->price * $product->discount) / 100;
                                                    }
                                                @endphp
                                                <span>{{ number_format($after_discount, 0) }}đ</span>
                                                @if ($product->discount != 0)
                                                    <del
                                                        style="padding-left:4%;">{{ number_format($product->price, 0) }}đ</del>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <h4 class="text-warning" style="margin:100px auto;">Không có sản phẩm nào.</h4>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-md-12 justify-content-center d-flex">
                                {{ $products->appends(request()->input())->links() }}
                                <!-- Đảm bảo các tham số URL được giữ lại -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>

    @push('styles')
        <style>
            .pagination {
                display: inline-flex;
            }

            .filter_button {
                text-align: center;
                background: #F7941D;
                padding: 8px 16px;
                margin-top: 10px;
                color: white;
            }
        </style>
    @endpush



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

        .shop.section {
            margin-top: 10px;
            /* Giảm khoảng cách */
            padding-top: 0;
            /* Nếu có padding, giảm hoặc loại bỏ */
        }

        .categor-list li {
            margin-bottom: -8px;
            /* Giảm khoảng cách giữa các danh mục */

        }

        .categor-list ul {
            padding-left: 15px;
            /* Dịch danh mục con vào gần danh mục cha hơn */
        }

        .shop-sidebar .categor-list li {
            margin-bottom: -8px;
            padding-top: 8px;
        }

        .shop-sidebar .categor-list {
            margin-top: -34px;
        }

        .categor-list li a {
            display: block;
            /* Giúp link chiếm toàn bộ vùng click */
            padding: 1px 4px;
            /* Cân chỉnh khoảng cách bên trong */
        }
    </style>
@endpush
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    {{-- <script>
        $('.cart').click(function(){
            var quantity=1;
            var pro_id=$(this).data('id');
            $.ajax({
                url:"{{route('add-to-cart')}}",
                type:"POST",
                data:{
                    _token:"{{csrf_token()}}",
                    quantity:quantity,
                    pro_id:pro_id
                },
                success:function(response){
                    console.log(response);
					if(typeof(response)!='object'){
						response=$.parseJSON(response);
					}
					if(response.status){
						swal('success',response.msg,'success').then(function(){
							document.location.href=document.location.href;
						});
					}
                    else{
                        swal('error',response.msg,'error').then(function(){
							// document.location.href=document.location.href;
						});
                    }
                }
            })
        });
    </script> --}}
    <script>
        $(document).ready(function() {
            $('.checkbox-list input[type="checkbox"]').change(function() {
                // Lấy tất cả giá trị của checkbox đã chọn
                const selectedPrices = [];
                $('.checkbox-list input[type="checkbox"]:checked').each(function() {
                    selectedPrices.push($(this).val());
                });

                // Cập nhật giá trị trong input ẩn hoặc thực hiện hành động khác
                $('#price_range').val(selectedPrices.join(','));

                // Nếu bạn muốn gửi form ngay lập tức
                // $('form').submit();
            });
        });
    </script>
@endpush
