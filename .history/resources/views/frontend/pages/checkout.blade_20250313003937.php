@extends('frontend.layouts.master')

@section('title',
    'Artisan
    || Thanh Toán')

@section('main-content')
    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{ route('home') }}">Trang Chủ<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="javascript:void(0)">Thanh Toán</a></li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <!-- Start Checkout -->
    <section class="shop checkout section">
        <div class="container">
            <form class="form" method="POST" action="{{ route('cart.order') }}">
                @csrf
                <div class="row">

                    <div class="col-lg-8 col-12">
                        <div class="checkout-form">
                            <h2>Thực Hiện Thanh Toán</h2>
                            <p>Vui lòng đăng ký để việc thanh toán nhanh chóng hơn.</p>

                            <!-- Form -->
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Tên<span>*</span></label>
                                        <input type="text" name="first_name" placeholder=""
                                            value="{{ old('first_name') }}" value="{{ old('first_name') }}">
                                        @error('first_name')
                                            <span class='text-danger'>{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Họ<span>*</span></label>
                                        <input type="text" name="last_name" placeholder="" value="{{ old('lat_name') }}">
                                        @error('last_name')
                                            <span class='text-danger'>{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Địa chỉ Email<span>*</span></label>
                                        <input type="email" name="email" placeholder="" value="{{ old('email') }}">
                                        @error('email')
                                            <span class='text-danger'>{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Số điện thoại <span>*</span></label>
                                        <input type="number" name="phone" placeholder="" value="{{ old('phone') }}">
                                        @error('phone')
                                            <span class='text-danger'>{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Địa chỉ<span>*</span></label>
                                        <input type="text" name="address1" id="address1" placeholder=""
                                            value="{{ old('address1') }}">
                                        @error('address1')
                                            <span class='text-danger'>{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-12">
                                        <div class="form-group">
                                            <select class="form-select" id="province" name="province"
                                                onchange="handleProvinceChange(this)">
                                                <option value="">Chọn tỉnh/thành phố</option>
                                                @foreach ($provinces as $province)
                                                    <option value="{{ $province->code }}">{{ $province->full_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('province')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-12">
                                        <div class="form-group">
                                            <select class="form-select" id="district" name="district">
                                                <option value="">Chọn quận/huyện</option>
                                            </select>
                                            @error('district')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-12">
                                        <div class="form-group">
                                            <select class="form-select" id="ward" name="ward">
                                                <option value="">Chọn phường/xã</option>
                                            </select>
                                            @error('ward')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--/ End Form -->
                        </div>
                    </div>
                    <div class="col-lg-4 col-12">
                        <div class="order-details">
                            <!-- Order Widget -->
                            <div class="single-widget">
                                <h2>Tổng Tiền Giỏ Hàng</h2>
                                <div class="content">
                                    <ul>
                                        <li class="order_subtotal" data-price="{{ Helper::totalCartPrice() }}">
                                            Tiền Sản Phẩm<span>{{ number_format(Helper::totalCartPrice(), 0) }}đ</span>
                                        </li>

                                        @if ($discount > 0)
                                            <li class="coupon_price">Giảm Giá:
                                                <span>{{ number_format($discount, 0) }}đ</span>
                                            </li>
                                        @endif

                                        <li class="shipping">
                                            Phương thức giao hàng (Bắt buộc) <span style="color: red;">*</span>
                                            @if (count(Helper::shipping()) > 0 && Helper::cartCount() > 0)
                                                <select name="shipping" class="nice-select" id="shippingSelect">
                                                    <option value="0" data-price="0" data-type="">Lựa chọn phương
                                                        thức giao hàng</option>
                                                    @foreach (Helper::shipping() as $shipping)
                                                        <option value="{{ $shipping->id }}" class="shippingOption"
                                                            data-price="{{ $shipping->price }}"
                                                            data-type="{{ $shipping->type }}">
                                                            {{ $shipping->type }}:
                                                            {{ number_format($shipping->price, 0) }}đ
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @else
                                                <div class="error-message"
                                                    style="color: red; display: flex; align-items: center; gap: 5px;">
                                                    <i class="fa fa-exclamation-circle" aria-hidden="true"></i> Không có
                                                    phí giao hàng khả dụng.
                                                </div>
                                            @endif
                                        </li>


                                        <li class="last" id="order_total_price" data-price="{{ $grandTotal }}">
                                            Tổng Tiền Cần Thanh Toán
                                            <span>{{ number_format($grandTotal, 0) }}đ</span>
                                        </li>



                                    </ul>
                                </div>
                            </div>


                            <!--/ End Order Widget -->
                            <!-- Order Widget -->
                            <div class="single-widget">
                                <h2>Payments</h2>
                                <div class="content">
                                    <div class="checkbox">
                                        <form-group>
                                            <input name="payment_method" type="radio" value="cod">
                                            <label> Thanh Toán Khi Nhận Hàng (POS)</label><br>
                                            <input name="payment_method" type="radio" value="momo">
                                            <label> Thanh Toán MoMo</label><br>


                                        </form-group>
                                    </div>
                                </div>
                            </div>

                            <div id="payment-error" style="color: red; margin-left: 30px;"></div>
                            <!--/ End Order Widget -->
                            <!-- Payment Method Widget -->

                            <div class="single-widget payement">
                                <div class="content">
                                    <img src="{{ 'backend/img/payment-method.png' }}" alt="#">
                                </div>
                            </div>
                            <!--/ End Payment Method Widget -->
                            <!-- Button Widget -->
                            <div class="single-widget get-button">
                                <div class="content">
                                    <div class="button">
                                        <button type="submit" class="btn">Thanh Toán</button>
                                    </div>
                                </div>
                            </div>
                            <!--/ End Button Widget -->
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <!--/ End Checkout -->

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
    <section class="shop-newsletter section" style="padding-top: 0px">
        <div class="container">
            <div class="inner-top">
                <div class="row">
                    <div class="col-lg-8 offset-lg-2 col-12">
                        <!-- Start Newsletter Inner -->
                        <div class="inner">
                            <h4>Tin Tức</h4>
                            <p> Đăng ký nhận thông báo tin tức mới nhất và được giảm giá <span>10%</span> giá trị đơn hàng
                                đầu tiên</p>
                            <form action="{{ route('subscribe') }}" method="post" class="newsletter-inner">
                                @csrf
                                <input name="email1" placeholder="Nhập Email của bạn...." required=""
                                    type="email">
                                <button class="btn" type="submit">Đăng Ký</button>
                            </form>
                        </div>
                        <!-- End Newsletter Inner -->
                    </div>
                </div>
            </div>
        </div>

    </section>


@endsection
@push('styles')
    <style>
        select option {
            font-size: 0.8rem;
            /* Adjust this value to make the text smaller or bigger */
        }


        li.shipping {
            display: inline-flex;
            width: 100%;
            font-size: 14px;
        }

        li.shipping .input-group-icon {
            width: 100%;
            margin-left: 10px;
        }

        .input-group-icon .icon {
            position: absolute;
            left: 20px;
            top: 0;
            line-height: 40px;
            z-index: 3;
        }

        .form-select {
            height: 30px;
            width: 100%;
        }

        .form-select .nice-select {
            border: none;
            border-radius: 0px;
            height: 40px;
            background: #f6f6f6 !important;
            padding-left: 45px;
            padding-right: 40px;
            width: 100%;
        }

        .list li {
            margin-bottom: 0 !important;
        }

        .list li:hover {
            background: #F7941D !important;
            color: white !important;
        }

        .form-select .nice-select::after {
            top: 14px;
        }

        .is-invalid {
            border-color: red;
            /* Đổi màu viền thành đỏ */
        }

        .error input,
        .error select {
            border-color: red;
        }
    </style>
@endpush

@push('scripts')
    <script src="{{ asset('frontend/js/nice-select/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('frontend/js/select2/js/select2.min.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Khởi tạo Nice Select
            $('#district, #ward').niceSelect();

            // Dữ liệu từ Laravel
            const districts = @json($districts);
            const wards = @json($wards);

            // Ban đầu vô hiệu hóa huyện và xã
            $('#district, #ward').prop("disabled", true).niceSelect('update');

            window.handleProvinceChange = function(selectElement) {
                const districtSelect = document.getElementById("district");
                const wardSelect = document.getElementById("ward");

                const provinceCode = selectElement.value;
                console.log("Selected Province:", provinceCode);

                // Xóa nội dung cũ
                districtSelect.innerHTML = '<option value="">-- Chọn huyện --</option>';
                wardSelect.innerHTML = '<option value="">-- Chọn xã --</option>';

                if (!provinceCode) {
                    // Nếu không có tỉnh, disable huyện và xã
                    $('#district, #ward').prop("disabled", true).niceSelect('update');
                    return;
                }

                // Lọc huyện theo tỉnh đã chọn
                const filteredDistricts = districts.filter(d => d.code.startsWith(provinceCode));

                if (filteredDistricts.length > 0) {
                    filteredDistricts.forEach(district => {
                        let option = document.createElement('option');
                        option.value = district.code;
                        option.textContent = district.full_name;
                        districtSelect.appendChild(option);
                    });

                    // Mở khóa huyện, tiếp tục disable xã
                    $('#district').prop("disabled", false).niceSelect('update');
                    $('#ward').prop("disabled", true).niceSelect('update');
                } else {
                    // Nếu không có huyện, disable cả huyện và xã
                    $('#district, #ward').prop("disabled", true).niceSelect('update');
                }
            };

            // Xử lý khi chọn huyện => Cập nhật danh sách xã
            $('#district').on("change", function() {
                const wardSelect = document.getElementById("ward");
                const districtCode = this.value;

                // Xóa nội dung cũ
                wardSelect.innerHTML = '<option value="">-- Chọn xã --</option>';

                if (!districtCode) {
                    // Nếu không có huyện, disable xã
                    $('#ward').prop("disabled", true).niceSelect('update');
                    return;
                }

                // Lọc xã theo huyện đã chọn
                const filteredWards = wards.filter(w => w.district_code === districtCode);

                if (filteredWards.length > 0) {
                    filteredWards.forEach(ward => {
                        let option = document.createElement('option');
                        option.value = ward.code;
                        option.textContent = ward.full_name;
                        wardSelect.appendChild(option);
                    });

                    // Mở khóa xã
                    $('#ward').prop("disabled", false).niceSelect('update');
                } else {
                    // Nếu không có xã, disable xã
                    $('#ward').prop("disabled", true).niceSelect('update');
                }
            });
        });
    </script>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let provinceSelect = document.getElementById("province");
            let districtSelect = document.getElementById("district");
            let wardSelect = document.getElementById("ward");
            let addressInput = document.getElementById("address1");

            function updateAddress() {
                let province = provinceSelect.options[provinceSelect.selectedIndex]?.text || "";
                let district = districtSelect.options[districtSelect.selectedIndex]?.text || "";
                let ward = wardSelect.options[wardSelect.selectedIndex]?.text || "";

                addressInput.value = `${ward ? ward + ", " : ""}${district ? district + ", " : ""}${province}`;
            }

            // Lắng nghe sự kiện thay đổi
            provinceSelect.addEventListener("change", updateAddress);
            districtSelect.addEventListener("change", updateAddress);
            wardSelect.addEventListener("change", updateAddress);
        });
    </script>

    <script>
        $(document).ready(function() {
            // Kích hoạt Nice Select cho dropdown
            $('select.nice-select').niceSelect();

            // Lắng nghe sự kiện thay đổi của dropdown "shipping"
            $('select[name="shipping"]').on('change', function() {
                // Lấy giá trị phí giao hàng từ data-price của option được chọn
                const selectedOption = $(this).find('option:selected');
                const shippingCost = parseFloat(selectedOption.data('price')) || 0;

                // Lấy tổng tiền giỏ hàng từ helper hoặc element hiện tại
                const cartTotal = parseFloat($('#order_total_price').data('price')) || 0;

                // Kiểm tra nếu cartTotal hợp lệ
                if (isNaN(cartTotal)) {
                    console.error("Không thể lấy tổng tiền sản phẩm.");
                    return;
                }

                // Tính tổng tiền mới
                const totalAmount = cartTotal + shippingCost;

                // Cập nhật tổng tiền lên giao diện
                $('#order_total_price span').text(totalAmount.toLocaleString('vi-VN') + 'đ');
            });

            // Gọi sự kiện 'change' ngay lập tức nếu đã có giá trị mặc định khi trang được tải
            $('select[name="shipping"]').trigger('change');

            // Kiểm tra khi submit form
            $('form').on('submit', function(event) {
                let hasError = false;

                // Xóa thông báo lỗi cũ
                $('input, select').removeClass('is-invalid');
                $('.error-message').remove();

                // Hàm tạo thông báo lỗi với biểu tượng chữ "i" đỏ
                function showError(element, message) {
                    hasError = true;
                    $(element).addClass('is-invalid');
                    $(element).after(
                        `<span class="error-message" style="color: red; display: flex; align-items: center; gap: 5px;">
                <i class="fa fa-exclamation-circle" aria-hidden="true"></i> ${message}
            </span>`
                    );
                }

                // Kiểm tra Họ và Tên riêng biệt
                if ($('input[name="first_name"]').val().trim() === "") {
                    showError('input[name="first_name"]', 'Vui lòng nhập Tên.');
                }

                if ($('input[name="last_name"]').val().trim() === "") {
                    showError('input[name="last_name"]', 'Vui lòng nhập Họ.');
                }

                // Kiểm tra Email
                if ($('input[name="email"]').val().trim() === "") {
                    showError('input[name="email"]', 'Vui lòng nhập Email.');
                }

                // Kiểm tra Số điện thoại
                if ($('input[name="phone"]').val().trim() === "") {
                    showError('input[name="phone"]', 'Vui lòng nhập Số điện thoại.');
                }

                // Kiểm tra Địa chỉ
                if ($('input[name="address1"]').val().trim() === "") {
                    showError('input[name="address1"]', 'Vui lòng nhập Địa chỉ.');
                }

                // Kiểm tra phương thức thanh toán
                if ($('input[name="payment_method"]:checked').length === 0) {
                    showError('input[name="payment_method"]:last', 'Vui lòng chọn phương thức thanh toán.');
                }

                // Kiểm tra phương thức giao hàng
                const selectedShipping = $('select[name="shipping"]').val();
                if (!selectedShipping || selectedShipping === "0") {
                    showError('select[name="shipping"]', 'Vui lòng chọn phương thức giao.');
                }

                // Nếu có lỗi, ngừng submit form
                if (hasError) {
                    event.preventDefault();
                }
            });


        });
    </script>
@endpush
