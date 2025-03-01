@extends('frontend.layouts.master')

@section('title', 'Artisan || Liên Hệ')

@section('main-content')
    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{ route('home') }}">Trang Chủ<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="javascript:void(0);">Liên Hệ</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <section id="contact-us" class="contact-us section">
        <div class="container">
            <div class="contact-head">
                <div class="row">
                    <div class="col-lg-8 col-12">
                        <div class="form-main">
                            <div class="title">
                                @php
                                    $settings = DB::table('settings')->get();
                                @endphp
                                <h4>Liên Lạc</h4>
                            <h3>Gửi cho chúng tôi một tin nhắn @auth @else<span style="font-size:12px;"
                                    class="text-danger">[Bạn cần phải đăng nhập để tiếp tục]</span>@endauth
                            </h3>
                        </div>
                        <form class="form-contact form contact_form" method="post"
                            action="{{ route('contact.store') }}" id="contactForm" novalidate="novalidate">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6 col-12">
                                    <div class="form-group">
                                        <label>Họ Tên<span>*</span></label>
                                        <input name="name" id="name" type="text" value="{{ old('name') }}"
                                            placeholder="Nhập họ tên của bạn">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-12">
                                    <div class="form-group">
                                        <label>Bạn cần thông tin về sản phẩm/dịch vụ gì ?<span>*</span></label>
                                        <input name="subject" type="text" id="subject" value="{{ old('subject') }}"
                                            placeholder="Nhập thông tin">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-12">
                                    <div class="form-group">
                                        <label>Email của bạn<span>*</span></label>
                                        <input name="email" type="email" id="email" value="{{ old('email') }}"
                                            placeholder="Nhập Email của bạn">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-12">
                                    <div class="form-group">
                                        <label>Số điện thoại<span>*</span></label>
                                        <input id="phone" name="phone" type="number" value="{{ old('phone') }}"
                                            placeholder="Nhập số điện thoại của bạn">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group message">
                                        <label>Nội dung<span>*</span></label>
                                        <textarea name="message" id="message" cols="30" rows="9" placeholder="Nhập nội dung">{{ old('message') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group button">
                                        <button type="submit" class="btn ">Gửi tin nhắn</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- Display success message -->
                        @if (session('success'))
                            <div class="alert alert-success mt-3">
                                {{ session('success') }}
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4 col-12">
                    <div class="single-head">
                        <div class="single-info">
                            <i class="fa fa-phone"></i>
                            <h4 class="title">Gọi cho chúng tôi ngay:</h4>
                            <ul>
                                <li>
                                    @foreach ($settings as $data)
                                        {{ $data->phone }}
                                    @endforeach
                                </li>
                            </ul>
                        </div>
                        <div class="single-info">
                            <i class="fa fa-envelope-open"></i>
                            <h4 class="title">Email:</h4>
                            <ul>
                                <li><a href="mailto:info@yourwebsite.com">
                                        @foreach ($settings as $data)
                                            {{ $data->email }}
                                        @endforeach
                                    </a></li>
                            </ul>
                        </div>
                        <div class="single-info">
                            <i class="fa fa-location-arrow"></i>
                            <h4 class="title">Địa chỉ của chúng tôi:</h4>
                            <ul>
                                <li>
                                    @foreach ($settings as $data)
                                        {{ $data->address }}
                                    @endforeach
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--/ End Contact -->

<!-- Map Section -->
<div class="map-section">
    <div id="myMap">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3928.841518442049!2d105.76804037487176!3d10.029933690076973!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31a0895a51d60719%3A0x9d76b0035f6d53d0!2zxJDhuqFpIGjhu41jIEPhuqduIFRoxqE!5e0!3m2!1svi!2s!4v1729689708647!5m2!1svi!2s"
            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
</div>
<!--/ End Map Section -->

<!-- Start Shop Newsletter  -->
@include('frontend.layouts.newsletter')
<!-- End Shop Newsletter -->

@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
@endpush

@push('scripts')
<script src="{{ asset('frontend/js/jquery.form.js') }}"></script>
<script src="{{ asset('frontend/js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('frontend/js/contact.js') }}"></script>

<script>
    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '{{ session('success') }}',
        }).then(function() {
            // Optionally reset the form
            $('#contactForm')[0].reset();
        });
    @endif

    // Handle the form submission
    $('#contactForm').submit(function(e) {
        e.preventDefault();

        $.ajax({
            type: 'POST',
            url: "{{ route('contact.store') }}",
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Thành công!',
                        text: response.success,
                    }).then(function() {
                        // Reset form fields
                        $('#contactForm')[0].reset();
                    });
                }
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Có lỗi xảy ra, vui lòng thử lại!',
                });
            }
        });
    });
</script>
@endpush
