@extends('frontend.layouts.master')

@section('title', 'Artisan || Đặt lại Mật Khẩu')

@section('main-content')
    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{ route('home') }}">Trang Chủ<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="javascript:void(0);">Đặt lại Mật Khẩu</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <!-- Start Reset Password Section -->
    <section id="reset-password" class="reset-password section">
        <div class="container">
            <div class="reset-head">
                <div class="row">
                    <div class="col-lg-6 col-12 offset-lg-3">
                        <div class="form-main">
                            <div class="title">
                                <h4>Đặt lại Mật Khẩu</h4>
                                <h3>Vui lòng nhập thông tin của bạn</h3>
                            </div>
                            <form id="resetPasswordForm" method="POST" action="{{ route('password.update') }}">
                                @csrf
                                <input type="hidden" name="token" value="{{ $token }}">

                                <div class="form-group">
                                    <label>Địa Chỉ Email<span>*</span></label>
                                    <input type="email" name="email" required placeholder="Nhập email của bạn"
                                        class="form-control">
                                </div>

                                <div class="form-group">
                                    <label>Mật Khẩu Mới<span>*</span></label>
                                    <input type="password" name="password" required placeholder="Nhập mật khẩu mới"
                                        class="form-control">
                                </div>

                                <div class="form-group">
                                    <label>Xác Nhận Mật Khẩu<span>*</span></label>
                                    <input type="password" name="password_confirmation" required
                                        placeholder="Nhập lại mật khẩu mới" class="form-control">
                                </div>

                                <div class="form-group button">
                                    <button type="submit" class="btn">Đặt lại Mật Khẩu</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/ End Reset Password Section -->
@endsection

@push('styles')
    <style>
        .reset-password .form-main {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }

        .reset-password .title {
            text-align: center;
            margin-bottom: 20px;
        }

        .reset-password .form-group {
            margin-bottom: 15px;
        }

        .reset-password .form-control {
            border-radius: 4px;
            border: 1px solid #ced4da;
            padding: 10px;
            width: 100%;
        }

        .reset-password .btn {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 10px 20px;
            cursor: pointer;
            width: 100%;
        }

        .reset-password .btn:hover {
            background-color: #0056b3;
        }

        .error {
            color: #e3342f;
            font-size: 0.9em;
            margin-top: 5px;
        }

        .error input {
            border-color: #e3342f;
        }
    </style>
@endpush

@push('scripts')
    <!-- Thêm jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Thêm jQuery Validation -->
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <script>
        $(document).ready(function() {
            // Điền email từ URL nếu có
            const urlParams = new URLSearchParams(window.location.search);
            const email = urlParams.get('email');
            if (email) {
                $('input[name="email"]').val(email);
            }

            // Sử dụng jQuery Validation
            $('#resetPasswordForm').validate({
                rules: {
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true,
                        minlength: 6
                    },
                    password_confirmation: {
                        required: true,
                        equalTo: 'input[name="password"]'
                    }
                },
                messages: {
                    email: {
                        required: "Vui lòng nhập email của bạn",
                        email: "Email không đúng định dạng"
                    },
                    password: {
                        required: "Vui lòng nhập mật khẩu mới",
                        minlength: "Mật khẩu phải có ít nhất 6 ký tự"
                    },
                    password_confirmation: {
                        required: "Vui lòng xác nhận mật khẩu mới",
                        equalTo: "Mật khẩu xác nhận không khớp với mật khẩu mới"
                    }
                },
                errorClass: 'error',
                highlight: function(element) {
                    $(element).css('border-color', '#e3342f');
                },
                unhighlight: function(element) {
                    $(element).css('border-color', '#ced4da');
                },
                errorPlacement: function(error, element) {
                    error.insertAfter(element);
                }
            });
        });
    </script>
@endpush
