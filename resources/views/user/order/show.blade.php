@extends('user.layouts.master')

@section('title', 'Chi tiết đơn hàng')

@section('main-content')
    <div class="card">
        <h5 class="card-header">Đơn hàng
            <a href="{{ route('order.pdf', $order->id) }}" class=" btn btn-sm btn-primary shadow-sm float-right"><i
                    class="fas fa-download fa-sm text-white-50"></i> Tạo PDF</a>
        </h5>
        <div class="card-body">
            @if ($order)
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Mã đơn hàng</th>
                            <th>Tên</th>
                            <th>Email</th>
                            <th>Số lượng</th>
                            <th>Phí vận chuyển</th>
                            <th>Tổng</th>
                            <th>Trạng thái</th>
                            {{--            <th>Thao tác</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->order_number }}</td>
                            <td>{{ $order->first_name }} {{ $order->last_name }}</td>
                            <td>{{ $order->email }}</td>
                            <td>{{ $order->quantity }}</td>
                            <td>{{ number_format(optional($order->shipping)->price ?? 'Không có thông tin', 0) }}đ</td>

                            <td>{{ number_format($order->total_amount, 0) }}đ</td>
                            <td>
                                @if ($order->status == 'new')
                                    <span class="badge badge-primary">{{ $order->status }}</span>
                                @elseif($order->status == 'process')
                                    <span class="badge badge-warning">{{ $order->status }}</span>
                                @elseif($order->status == 'delivered')
                                    <span class="badge badge-success">{{ $order->status }}</span>
                                @else
                                    <span class="badge badge-danger">{{ $order->status }}</span>
                                @endif
                            </td>


                        </tr>
                    </tbody>
                </table>
                <h4 class="text-center mt-3 fw-bold pb-4">Chi tiết đơn hàng</h4>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên sản phẩm</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Hình ảnh</th>
                        </tr>
                    </thead>

                    <tbody>
                        @php
                            $totalPrice = 0;
                        @endphp
                        @foreach ($order->orderDetail as $key => $order_item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $order_item->product->title }}</td> <!-- Hiển thị tên sản phẩm -->
                                <td>{{ number_format($order_item->product->price, 0) }}đ</td>
                                <!-- Hiển thị giá sản phẩm -->
                                <td>{{ $order_item->quantity }}</td> <!-- Hiển thị số lượng -->
                                <td>
                                    <img src="{{ $order_item->product->photo }}" class="img-fluid zoom"
                                        style="max-width:80px" alt="">
                                </td>
                            </tr>
                            @php
                                $totalPrice += $order_item->product->price * $order_item->quantity;
                            @endphp
                        @endforeach
                        <!-- Dòng tổng cùng trong bảng -->
                        <tr style="font-weight: bold; font-size: 22px; color: #333;">
                            <td colspan="5" class="text-right">
                                <span style="font-size: 20px">Tổng:</span>
                            </td>
                            <td style="font-size: 18px; text-align: center">
                                {{ number_format($totalPrice, 0) }}đ
                            </td>
                        </tr>
                    </tbody>
                </table>

                <section class="confirmation_part section_padding">
                    <div class="order_boxes">
                        <div class="row">
                            <div class="col-lg-6 col-lx-4">
                                <div class="order-info">
                                    <h4 class="text-center pb-4">Thông tin đơn hàng</h4>
                                    <table class="table">
                                        <tr class="">
                                            <td>Mã đơn hàng</td>
                                            <td> : {{ $order->order_number }}</td>
                                        </tr>
                                        <tr>
                                            <td>Ngày đặt hàng</td>
                                            <td> : {{ $order->created_at->format('D d M, Y') }} at
                                                {{ $order->created_at->format('g : i a') }} </td>
                                        </tr>
                                        <tr>
                                            <td>Số lượng</td>
                                            <td> : {{ $order->quantity }}</td>
                                        </tr>
                                        <tr>
                                            <td>Trạng thái đơn hàng</td>
                                            <td> : {{ $order->status }}</td>
                                        </tr>
                                        @php
                                            $shipping_charge = DB::table('shippings')
                                                ->where('id', $order->shipping_id)
                                                ->value('price');
                                        @endphp
                                        <tr>
                                            <td>Phí vận chuyển</td>
                                            <td> : {{ $shipping_charge ?? 'Không có thông tin' }}đ</td>
                                        </tr>


                                        <tr>
                                            <td>Tổng</td>
                                            <td> : {{ number_format($order->total_amount, 0) }}đ</td>
                                        </tr>
                                        <tr>
                                            <td>Phương thức vận chyển</td>
                                            <td> : @if ($order->payment_method == 'cod')
                                                    Thanh toán khi nhận hàng
                                                @else
                                                    Thanh toán qua PayPal
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Trạng thái thanh toán</td>
                                            <td> : {{ $order->payment_status }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <div class="col-lg-6 col-lx-4">
                                <div class="shipping-info">
                                    <h4 class="text-center pb-4">Thông tin giao hàng</h4>
                                    <table class="table">
                                        <tr class="">
                                            <td>Tên đầy đủ</td>
                                            <td> : {{ $order->first_name }} {{ $order->last_name }}</td>
                                        </tr>
                                        <tr>
                                            <td>Email</td>
                                            <td> : {{ $order->email }}</td>
                                        </tr>
                                        <tr>
                                            <td>Số điện thoại</td>
                                            <td> : {{ $order->phone }}</td>
                                        </tr>
                                        <tr>
                                            <td>Địa chỉ</td>
                                            <td> : {{ $order->address1 }}, {{ $order->address2 }}</td>
                                        </tr>
                                        <tr>
                                            <td>Quốc gia</td>
                                            <td> : {{ $order->country }}</td>
                                        </tr>
                                        <tr>
                                            <td>Mã bưu điện</td>
                                            <td> : {{ $order->post_code }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            @endif

        </div>
    </div>
@endsection

@push('styles')
    <style>
        .table {
            width: 100%;
            table-layout: auto;
        }

        .order-info,
        .shipping-info {
            background: #ECECEC;
            padding: 20px;
        }

        .order-info h4,
        .shipping-info h4 {
            text-decoration: underline;
        }
    </style>
@endpush
