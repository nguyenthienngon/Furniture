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
                                <h3>Nhập địa chỉ email của bạn</h3>
                            </div>
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <form method="POST" action="{{ route('password.email') }}" id="reset-password-form">
                                @csrf
                                <div class="form-group">
                                    <label>Email Address<span>*</span></label>
                                    <input type="email" name="email" required autofocus placeholder="Nhập Email của bạn"
                                        class="form-control">
                                </div>
                                <div class="form-group button">
                                    <button type="submit" class="btn">Gửi Link Đặt lại Mật Khẩu</button>
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
            background-color: #ffffff;
            border-radius: 8px;
            padding: 40px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            margin-top: 50px;
        }

        .reset-password .form-main .title {
            text-align: center;
            margin-bottom: 25px;
        }

        .reset-password .form-main .title h3 {
            font-size: 1.5em;
            color: #333;
        }

        .reset-password .form-group {
            margin-bottom: 20px;
        }

        .reset-password .form-control {
            border-radius: 5px;
            border: 1px solid #ddd;
            padding: 12px;
            transition: border-color 0.2s ease-in-out;
        }

        .reset-password .form-control:focus {
            border-color: #007bff;
            box-shadow: none;
        }

        .reset-password .btn {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 12px 24px;
            width: 100%;
            font-size: 1em;
            transition: background-color 0.2s ease-in-out;
        }

        .reset-password .btn:hover {
            background-color: #0056b3;
        }

        .alert {
            text-align: center;
        }

        .error {
            color: #e3342f;
            /* Màu đỏ */
            font-size: 0.9em;
            margin-top: 5px;
        }
    </style>
@endpush
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <script>
        $(document).ready(function() {
            // Xác thực email có định dạng đúng
            $('#reset-password-form').validate({
                rules: {
                    email: {
                        required: true,
                        email: true
                    }
                },
                messages: {
                    email: {
                        required: "Vui lòng nhập email của bạn",
                        email: "Email không đúng định dạng"
                    }
                },
                errorClass: 'error', // Sử dụng lớp CSS 'error' để hiện màu đỏ
                submitHandler: function(form) {
                    // Kiểm tra email tồn tại trong CSDL bằng AJAX
                    $.ajax({
                        url: '{{ route('password.email') }}',
                        method: 'POST',
                        data: $(form).serialize(),
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            form.submit();
                        },
                        error: function(xhr) {
                            if (xhr.status === 422) {
                                $('.alert-danger').remove();
                                $('<div class="alert alert-danger">Email không tồn tại. Vui lòng đăng ký tài khoản.</div>')
                                    .insertBefore(form);
                            }
                        }
                    });
                }
            });
        });
    </script>
@endpush
