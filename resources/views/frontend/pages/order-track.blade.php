@extends('frontend.layouts.master')

@section('title', 'Artisan || Trạng Thái Đơn Hàng')

@section('main-content')
    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{ route('home') }}">Home<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="javascript:void(0);">Trạng Thái Đơn Hàng</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->
    <section class="tracking_box_area section_gap py-5">
        <div class="container">
            <div class="tracking_box_inner">
                <p>Để theo dõi trạng thái đơn hàng của bạn vui lòng nhập mã đơn hàng vào ô bên dưới và nhấn nút "Kiếm tra".
                </p>
                <form class="row tracking_form my-4" id="trackingForm" action="{{ route('product.track.order') }}"
                    method="post" novalidate="novalidate">
                    @csrf
                    <div class="col-md-8 form-group">
                        <input type="text" class="form-control p-2" id="orderNumberInput" name="order_number"
                            placeholder="Nhập mã đơn hàng">
                    </div>
                    <div class="col-md-8 form-group">
                        <button type="submit" class="btn submit_btn">Kiểm tra</button>
                    </div>
                </form>

            </div>
        </div>
    </section>
@endsection

@push('scripts')
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('trackingForm').addEventListener('submit', function(event) {
                    event.preventDefault(); // Ngăn không cho form gửi yêu cầu mặc định

                    const orderNumber = document.getElementById('orderNumberInput').value;

                    fetch('{{ route('product.track.order') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                order_number: orderNumber
                            })
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            // Hiển thị thông báo SweetAlert
                            Swal.fire({
                                title: 'Thông báo',
                                text: data.message,
                                icon: data.icon,
                                confirmButtonText: 'OK'
                            });
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                title: 'Lỗi!',
                                text: 'Đã xảy ra lỗi, vui lòng thử lại.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        });
                });
            });
        </script>
    @endpush
@endpush
