@extends('frontend.layouts.master')

@section('title', 'Artisan || Giới Thiệu')

@section('main-content')
    <style>
        .about-content h3 {
            margin-bottom: 20px;
            /* Khoảng cách giữa tiêu đề và đoạn văn */
        }

        .about-content h4 {
            margin: 12px 0;
            /* Khoảng cách 8px trên và dưới cho thẻ h4 */
        }

        .about-content p {
            margin-bottom: 15px;
            /* Khoảng cách giữa các đoạn văn */
            line-height: 1.6;
            /* Tăng chiều cao dòng để dễ đọc hơn */
        }

        .about-content ul {
            padding-left: 20px;
            /* Khoảng cách bên trái cho danh sách */
            margin-bottom: 20px;
            /* Khoảng cách giữa danh sách và phần nội dung tiếp theo */
        }

        .about-content ul li {
            margin-bottom: 15px;
            /* Khoảng cách giữa các mục trong danh sách */
            display: flex;
            justify-content: space-between;
            /* Căn chỉnh đều các mục */
        }

        .customer-reviews blockquote {
            margin-bottom: 20px;
            /* Khoảng cách giữa các đánh giá */
            padding: 10px;
            /* Khoảng cách bên trong cho các đánh giá */
            border-left: 5px solid #ddd;
            /* Đường viền bên trái cho các đánh giá */
            background-color: #f9f9f9;
            /* Màu nền cho các đánh giá */
        }

        .product-item h5 {
            margin-top: 15px;
            /* Khoảng cách giữa hình ảnh và tiêu đề sản phẩm */
        }

        .product-highlight-title {
            margin-bottom: 30px;
            /* Khoảng cách giữa tiêu đề sản phẩm nổi bật và nội dung bên dưới */
        }
    </style>

    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{ route('home') }}">Trang Chủ<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="#">Giới Thiệu</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <!-- About Us -->
    <section class="about-us section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-12">
                    <div class="about-content">
                        @php
                            $settings = DB::table('settings')->first(); // Lấy 1 bản ghi duy nhất
                        @endphp
                        <h3>Chào mừng tới <span>Artisan</span></h3>
                        <p>
                            Artisan tự hào mang đến cho bạn những sản phẩm nội thất chất lượng cao, thiết kế tinh tế và sang
                            trọng. Chúng tôi cam kết mang lại trải nghiệm tốt nhất cho khách hàng với những sản phẩm được
                            lựa chọn kỹ lưỡng.
                        </p>
                        <p>
                            Với sứ mệnh làm cho không gian sống của bạn trở nên đẹp hơn, Artisan không ngừng đổi mới và cải
                            tiến để phục vụ nhu cầu của khách hàng. Chúng tôi cung cấp nhiều sản phẩm từ đồ nội thất cho đến
                            trang trí, đáp ứng mọi nhu cầu của bạn.
                        </p>
                        <h4>Giá Trị Cốt Lõi Của Chúng Tôi</h4>

                        <li><strong>Chất lượng hàng đầu:</strong> Sản phẩm được sản xuất từ nguyên liệu cao cấp.</li>
                        <li><strong>Thiết kế hiện đại:</strong> Đội ngũ thiết kế chuyên nghiệp mang đến những xu hướng
                            mới nhất.</li>
                        <li><strong>Dịch vụ khách hàng tận tâm:</strong> Đội ngũ hỗ trợ khách hàng luôn sẵn sàng giúp
                            đỡ.</li>

                        <div class="button">
                            <a href="{{ route('blog') }}" class="btn">Bài Viết</a>
                            <a href="{{ route('contact') }}" class="btn primary">Liên Hệ</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-12">
                    <div class="about-img overlay">
                        <img src="{{ asset('images/gt1.jpg') }}" alt="Artisan - Nội Thất"
                            style="width: 100%; height: auto;">
                    </div>
                </div>
            </div>

            <!-- Thêm hình ảnh sản phẩm -->
            <div class="row mt-5">
                <div class="col-12">
                    <h4 class="product-highlight-title">Sản Phẩm Nổi Bật</h4>
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-12 mb-4">
                            <div class="product-item">
                                <img src="{{ asset('images/sofa1.jpg') }}" alt="Sofa hiện đại" class="img-fluid">
                                <h5>Sofa Hiện Đại</h5>
                                <p>Thiết kế sang trọng, mang lại sự thoải mái cho không gian sống.</p>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-12 mb-4">
                            <div class="product-item">
                                <img src="{{ asset('images/bp2a.jpg') }}" alt="Bàn Ăn Gỗ" class="img-fluid">
                                <h5>Bàn Ăn Gỗ</h5>
                                <p>Được chế tác tinh xảo từ gỗ tự nhiên, bền bỉ theo thời gian.</p>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-12 mb-4">
                            <div class="product-item">
                                <img src="{{ asset('images/gn1.jpg') }}" alt="Ghế thư giãn" class="img-fluid">
                                <h5>Ghế Thư Giãn</h5>
                                <p>Thiết kế độc đáo, lý tưởng cho những phút giây thư giãn.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Thêm phần đánh giá từ khách hàng -->
            <div class="row mt-5">
                <div class="col-12">
                    <h4>Đánh Giá Khách Hàng</h4>
                    <div class="customer-reviews">
                        <blockquote>
                            <p>"Sản phẩm của Artisan thực sự tuyệt vời! Tôi rất hài lòng với chất lượng và thiết kế." -
                                <strong>Nguyễn Văn A</strong>
                            </p>
                        </blockquote>
                        <blockquote>
                            <p>"Dịch vụ khách hàng rất tốt, tôi đã nhận được sự hỗ trợ tận tình khi cần." - <strong>Trần Thị
                                    B</strong></p>
                        </blockquote>
                        <blockquote>
                            <p>"Tôi đã mua nhiều sản phẩm từ Artisan và luôn hài lòng với lựa chọn của mình." - <strong>Lê
                                    Văn C</strong></p>
                        </blockquote>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- End About Us -->

    <!-- Start Shop Services Area -->
    <section class="shop-services section home">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="single-service">
                        <i class="ti-rocket"></i>
                        <h4>Miễn Phí Giao Hàng</h4>
                        <p>Cho đơn hàng trên 1.000.000 đ</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="single-service">
                        <i class="ti-reload"></i>
                        <h4>Miễn Phí Hoàn Trả</h4>
                        <p>Trong vòng 30 ngày</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="single-service">
                        <i class="ti-lock"></i>
                        <h4>Bảo Mật Thanh Toán</h4>
                        <p>100% Bảo Mật Thanh Toán</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="single-service">
                        <i class="ti-tag"></i>
                        <h4>Giá Tốt Nhất</h4>
                        <p>Đảm Bảo Giá Tốt Nhất</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Shop Services Area -->

    @include('frontend.layouts.newsletter')
@endsection
