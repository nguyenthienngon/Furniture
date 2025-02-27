@extends('frontend.layouts.master')
@section('title', 'Cart Page')
@section('main-content')
    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{ 'home' }}">Trang Chủ<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="">Giỏ Hàng</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <!-- Shopping Cart -->
    <div class="shopping-cart section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- Shopping Summery -->
                    <table class="table shopping-summery">
                        <thead>
                            <tr class="main-hading">
                                <th style="vertical-align: middle; text-align: center; color: #000;">Ảnh Sản Phẩm</th>
                                <th style="vertical-align: middle; text-align: center;color: #000;">Tên Sản Phẩm</th>
                                <th class="text-center" style="vertical-align: middle;color: #000;">Đơn Giá</th>
                                <th class="text-center" style="vertical-align: middle;color: #000;">Số Lượng</th>
                                <th class="text-center" style="vertical-align: middle;color: #000;">Tổng Tiền</th>
                                <th class="text-center" style="vertical-align: middle;color: #000;"><i
                                        class="ti-trash remove-icon"></i>
                                </th>
                            </tr>
                        </thead>

                        <tbody id="cart_item_list">
                            <form action="{{ route('cart.update') }}" method="POST">
                                @csrf
                                @if (Helper::getAllProductFromCart())
                                    @foreach (Helper::getAllProductFromCart() as $key => $cart)
                                        <tr>
                                            @php
                                                $photo = explode(',', $cart->product['photo']);
                                            @endphp
                                            <td class="image" data-title="No"><img src="{{ $photo[0] }}"
                                                    alt="{{ $photo[0] }}"></td>
                                            <td class="product-des" data-title="Description">
                                                <p class="product-name"><a
                                                        href="{{ route('product-detail', $cart->product['slug']) }}"
                                                        target="_blank">{{ $cart->product['title'] }}</a></p>
                                                <p class="product-des">{!! $cart['summary'] !!}</p>
                                            </td>
                                            <td class="price" data-title="Price">
                                                <span>{{ number_format($cart['price'], 0) }}đ</span>
                                            </td>
                                            <td class="qty" data-title="Qty"><!-- Input Order -->
                                                <div class="input-group">
                                                    <div class="button minus">
                                                        <button type="button" class="btn btn-primary btn-number"
                                                            data-type="minus" data-field="quant[{{ $key }}]">
                                                            <i class="ti-minus"></i>
                                                        </button>
                                                    </div>
                                                    <input type="text" name="quant[{{ $key }}]"
                                                        class="input-number" data-min="0" data-max="1000"
                                                        data-stock="{{ $cart->product['stock'] }}"
                                                        value="{{ $cart->quantity }}">
                                                    <input type="hidden" name="qty_id[]" value="{{ $cart->id }}">
                                                    <div class="button plus">
                                                        <button type="button" class="btn btn-primary btn-number"
                                                            data-type="plus" data-field="quant[{{ $key }}]">
                                                            <i class="ti-plus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <!--/ End Input Order -->
                                            </td>
                                            <td class="total-amount cart_single_price" data-title="Total"><span
                                                    class="money">{{ number_format($cart['amount']), 0 }}đ</span></td>

                                            <td class="action" data-title="Remove">
                                                <a href="{{ route('cart-delete', $cart->id) }}"><i
                                                        class="ti-trash remove-icons"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="text-center">
                                            Không có giỏ hàng nào có sẵn. <a href="{{ route('product-grids') }}"
                                                style="color:blue;">Tiếp tục mua sắm.</a>

                                        </td>
                                    </tr>
                                @endif

                            </form>
                        </tbody>
                    </table>
                    <!--/ End Shopping Summery -->
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <!-- Total Amount -->
                    <div class="total-amount">
                        <div class="row">
                            <div class="col-lg-8 col-md-5 col-12">
                                <div class="left">
                                    <div class="coupon">
                                        <form action="{{ route('coupon-store') }}" method="POST">
                                            @csrf
                                            <input name="code" placeholder="Nhập mã giảm giá">
                                            <button class="btn">Áp Dụng</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-7 col-12">
                                <div class="right">
                                    <ul>
                                        <li class="order_subtotal" data-price="{{ Helper::totalCartPrice() }}">Tổng Số Tiền
                                            <span>{{ number_format(Helper::totalCartPrice(), 0) }}đ</span>
                                        </li>

                                        @if (session()->has('coupon'))
                                            <li class="coupon_price" data-price="{{ Session::get('coupon')['value'] }}">Bạn
                                                tiết kiệm
                                                được<span>{{ number_format(Session::get('coupon')['value'], 0) }}đ</span>
                                            </li>
                                        @endif
                                        @php
                                            $total_amount = Helper::totalCartPrice();
                                            if (session()->has('coupon')) {
                                                $total_amount = $total_amount - Session::get('coupon')['value'];
                                            }
                                        @endphp
                                        @if (session()->has('coupon'))
                                            <li class="last" id="order_total_price">Bạn cần thanh
                                                toán<span>{{ number_format($total_amount, 0) }}đ</span></li>
                                        @else
                                            <li class="last" id="order_total_price">Bạn cần thanh
                                                toán<span>{{ number_format($total_amount, 0) }}đ</span></li>
                                        @endif
                                    </ul>


                                    <div class="button5">

                                        <a href="{{ route('checkout') }}" class="btn">Thanh Toán</a>
                                        <a href="{{ route('product-grids') }}" class="btn">Tiếp Tục Mua Sắm</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ End Total Amount -->
                </div>
            </div>
        </div>
    </div>
    <!--/ End Shopping Cart -->

    <!-- Start Shop Services Area -->
    <section class="shop-services section home">
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

    <!-- Start Shop Newsletter  -->
    @include('frontend.layouts.newsletter')
    <!-- End Shop Newsletter -->

@endsection
@push('styles')
    <style>
        /* Shipping list */
        li.shipping {
            display: flex;
            /* Đảm bảo các phần tử con nằm ngang */
            align-items: center;
            /* Canh giữa theo chiều dọc */
            width: 100%;
            font-size: 14px;
        }

        li.shipping .input-group-icon {
            width: 100%;
            margin-left: 10px;
            position: relative;
            /* Để phần icon căn chỉnh tốt hơn */
        }

        .input-group-icon .icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 3;
        }

        /* Form select styling */
        .form-select {
            width: 100%;
            height: 40px;
            /* Đồng bộ chiều cao */
            border-radius: 4px;
        }

        .form-select .nice-select {
            border: none;
            border-radius: 4px;
            height: 40px;
            background: #f6f6f6 !important;
            padding-left: 45px;
            padding-right: 40px;
            width: 100%;
        }

        .form-select .nice-select::after {
            top: 50%;
            transform: translateY(-50%);
        }

        /* List items */
        .list li {
            margin-bottom: 0 !important;
            padding: 8px 12px;
        }

        .list li:hover {
            background: #F7941D !important;
            color: white !important;
            cursor: pointer;
        }

        /* Table Styling */
        .text-center {
            text-align: center;
            vertical-align: middle;
        }

        .shopping-summery tbody tr {
            border-bottom: 1px solid rgba(0, 0, 0, 0.3);
            /* Đổi màu thành đen nhạt (mờ đi) */
        }
    </style>
@endpush

@push('scripts')
    <script src="{{ asset('frontend/js/nice-select/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('frontend/js/select2/js/select2.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $("select.select2").select2();
            $('select.nice-select').niceSelect();

            // Ensure that button clicks are properly handled only once
            $('.btn-number').off('click').on('click', function(e) {
                e.preventDefault();

                const type = $(this).data('type');
                const input = $(this).closest('.input-group').find('.input-number');
                const currentVal = parseInt(input.val()); // Get current value of input
                const maxStock = parseInt(input.data('stock')); // Stock quantity from data-stock

                let newVal = currentVal;

                if (type === 'minus') {
                    // Decrease quantity, but not below 1
                    if (currentVal > 1) {
                        newVal = currentVal - 1;
                    } else {
                        // If quantity is 1, ask user for confirmation to remove the product
                        confirmDelete(input.closest('tr').find('input[name="qty_id[]"]').val());
                        return; // Prevent further code execution
                    }
                } else if (type === 'plus') {
                    // Increase quantity by 1, but ensure it doesn't exceed stock
                    if (currentVal < maxStock) {
                        newVal = currentVal + 1;
                    } else {
                        // If quantity exceeds stock, alert the user
                        Swal.fire({
                            title: 'Thông báo',
                            text: 'Số lượng bạn chọn đã vượt quá số lượng tồn kho, không thể thêm nhiều hơn!',
                            icon: 'warning',
                            confirmButtonText: 'OK'
                        });
                        // Reset input to max stock if it's above the available stock
                        newVal = maxStock;
                    }
                }

                // Update input value with the new value (only once)
                input.val(newVal);

                // Update the cart amount based on the new quantity
                updateCartAmount(input);
            });

            // Function to update the total amount of a cart row when quantity changes
            function updateCartAmount(input) {
                const row = input.closest('tr');
                const price = parseFloat(row.find('.price span').text().replace('đ', '').replace(/,/g, ''));
                const quantity = parseInt(input.val());
                const total = price * quantity;

                // Update the total amount for this product
                row.find('.total-amount .money').text(new Intl.NumberFormat().format(total) + 'đ');

                // Update the overall total cart amount
                updateTotalAmount();
            }

            // Function to update the total cart amount
            function updateTotalAmount() {
                let cartTotal = 0;

                $('.cart_single_price .money').each(function() {
                    cartTotal += parseFloat($(this).text().replace('đ', '').replace(/,/g, ''));
                });

                $('.order_subtotal span').text(new Intl.NumberFormat().format(cartTotal) + 'đ');

                let coupon = parseFloat($('.coupon_price').data('price')) || 0;
                let finalTotal = cartTotal - coupon;
                $('#order_total_price span').text(new Intl.NumberFormat().format(finalTotal) + 'đ');
            }

            // Function to confirm deletion of product from the cart
            function confirmDelete(cartId) {
                Swal.fire({
                    title: 'Bạn có chắc muốn xóa sản phẩm khỏi giỏ hàng không?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Xóa',
                    cancelButtonText: 'Giữ lại'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Send the delete request via Ajax
                        $.ajax({
                            url: "{{ url('cart-delete') }}/" + cartId,
                            type: 'GET',
                            success: function(response) {
                                if (response.success) {
                                    // Remove the row from the UI
                                    $("tr").filter(function() {
                                        return $(this).find('input[name="qty_id[]"]')
                                            .val() == cartId;
                                    }).remove();
                                    updateTotalAmount(); // Update the total amount
                                    Swal.fire('Đã xóa!', response.message, 'success');
                                } else {
                                    Swal.fire('Lỗi', response.message, 'error');
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error('Lỗi:', error);
                                Swal.fire('Lỗi', 'Có lỗi xảy ra, vui lòng thử lại.', 'error');
                            }
                        });
                    }
                });
            }
        });
    </script>
@endpush
