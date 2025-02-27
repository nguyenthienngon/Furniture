@extends('frontend.layouts.master')

@section('title', 'Artisan || Đăng nhập')

@section('main-content')
    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{ route('home') }}">Trang Chủ<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="javascript:void(0);">Đăng nhập</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <!-- Shop Login -->
    <section class="shop login section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-12">
                    <div class="login-form">
                        <h2>Đăng nhập</h2>
                        <p>Vui lòng đăng nhập để quá trình thanh toán được nhanh chóng hơn.</p>
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <!-- Form -->
                        <form class="form" method="post" action="{{ route('login.submit') }}">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group @error('email') has-error @enderror">
                                        <label class="@error('email') text-danger @enderror">Tên đăng
                                            nhập<span>*</span></label>
                                        <input type="email" name="email" placeholder="Nhập email" required="required"
                                            value="{{ old('email') }}" class="@error('email') is-invalid @enderror">

                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group @error('email') has-error @enderror">
                                        <label class="@error('email') text-danger @enderror">Mật
                                            khẩu<span>*</span></label>
                                        <input type="password" name="password" placeholder="Nhập mật khẩu"
                                            required="required" class="@error('email') is-invalid @enderror">

                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group login-btn">
                                        <button class="btn" type="submit">Đăng nhập</button>
                                        <a href="{{ route('register.form') }}" class="btn">Đăng ký</a>
                                        OR
                                        <a href="{{ route('login.redirect', 'facebook') }}" class="btn btn-facebook"><i
                                                class="ti-facebook"></i></a>
                                        <a href="{{ route('login.redirect', 'google') }}" class="btn btn-google"><i
                                                class="ti-google"></i></a>

                                    </div>
                                    <div class="checkbox">
                                        <label class="checkbox-inline" for="2"><input name="news" id="2"
                                                type="checkbox">Lưu đăng nhập</label>
                                    </div>
                                    <a class="lost-pass" href="{{ route('password.request') }}">
                                        Bạn bị quên mật khẩu?
                                    </a>

                                </div>
                            </div>
                        </form>
                        <!--/ End Form -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/ End Login -->
@endsection
@push('styles')
    <style>
        .shop.login .form .btn {
            margin-right: 0;
        }

        .btn-facebook {
            background: #39579A;
        }

        .btn-facebook:hover {
            background: #073088 !important;
        }

        .btn-github {
            background: #444444;
            color: white;
        }

        .btn-github:hover {
            background: black !important;
        }

        .btn-google {
            background: #ea4335;
            color: white;
        }

        .btn-google:hover {
            background: rgb(243, 26, 26) !important;
        }

        .has-error input {
            border-color: #dc3545;
        }

        .text-danger {
            color: #dc3545 !important;
        }

        .is-invalid {
            border-color: #dc3545 !important;
        }

        .shop.login .form .form-group input {
            border: 1px solid #ccc;
            /* Viền mặc định */
            border-radius: 4px;
            /* Bo tròn nhẹ */
            padding: 10px;
            /* Khoảng cách bên trong */
            width: 100%;
            /* Đảm bảo chiều rộng full */
            box-sizing: border-box;
            /* Bao gồm cả padding và border trong width */
        }

        .has-error input {
            border-color: #dc3545;
            /* Viền đỏ khi có lỗi */
        }

        .is-invalid {
            border-color: #dc3545 !important;
            /* Viền đỏ ưu tiên khi có lỗi */
        }

        .text-danger {
            color: #dc3545 !important;
            /* Màu chữ đỏ */
        }

        input:focus {
            outline: none;
            /* Bỏ viền outline mặc định */
            border-color: #007bff;
            /* Viền xanh khi focus */
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
            /* Hiệu ứng ánh sáng khi focus */
        }
    </style>
@endpush
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Thành công!',
                text: '{{ session('success') }}',
                confirmButtonText: 'OK'
            });
        @endif
    </script>
@endpush
