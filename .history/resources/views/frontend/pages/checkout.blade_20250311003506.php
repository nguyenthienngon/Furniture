@push('styles')
    <style>
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


    <!-- End Shop Newsletter -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            let provincesData = [];
            let districtsData = [];
            let wardsData = [];

            $.getJSON("/js/address.json")
                .done(function(data) {
                    console.log("Dữ liệu JSON:", data);
                    provincesData = data;
                    populateProvinces();
                })
                .fail(function(jqxhr, textStatus, error) {
                    console.error("Lỗi tải JSON:", textStatus, error);
                    console.error("Phản hồi server:", jqxhr.responseText);
                });

            function populateProvinces() {
                const provinceSelect = $('#province');
                provinceSelect.empty().append('<option value="">Chọn Tỉnh/Thành phố</option>');
                provincesData.forEach(province => {
                    provinceSelect.append(
                        `<option value="${province.Code}">${province.FullName}</option>`
                    );
                });
            }

            $('#province').change(function() {
                const provinceCode = $(this).val();
                const districtSelect = $('#district');
                const wardSelect = $('#ward');
                districtSelect.empty().append('<option value="">Chọn Quận/Huyện</option>');
                wardSelect.empty().append('<option value="">Chọn Phường/Xã</option>');

                if (provinceCode) {
                    const selectedProvince = provincesData.find(p => p.Code === provinceCode);
                    districtsData = selectedProvince.District || [];
                    districtsData.forEach(district => {
                        districtSelect.append(
                            `<option value="${district.Code}">${district.FullName}</option>`
                        );
                    });
                }
            });

            $('#district').change(function() {
                const districtCode = $(this).val();
                const wardSelect = $('#ward');
                wardSelect.empty().append('<option value="">Chọn Phường/Xã</option>');

                if (districtCode) {
                    const selectedDistrict = districtsData.find(d => d.Code === districtCode);
                    wardsData = selectedDistrict.Ward || [];
                    wardsData.forEach(ward => {
                        wardSelect.append(
                            `<option value="${ward.Code}">${ward.FullName}</option>`
                        );
                    });
                }
            });
        });
    </script>
@endsection



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

            // Kiểm tra các trường bắt buộc (first_name, last_name, email, phone, country, address1, payment_method)
            $('input[name="first_name"], input[name="last_name"], input[name="email"], input[name="phone"], input[name="address1"], select[name="country"], input[name="payment_method"]:checked')
                .each(function() {
                    if ($(this).val() === "" || $(this).val() === undefined) {
                        hasError = true;
                        $(this).addClass('is-invalid');
                        $(this).after(
                            '<span class="error-message" style="color: red;">Vui lòng điền đầy đủ thông tin.</span>'
                        );
                    }
                });

            // Kiểm tra phí giao hàng


            // Nếu có lỗi, ngừng submit form
            if (hasError) {
                event.preventDefault();
            }
        });
    });
</script>
@endpush
