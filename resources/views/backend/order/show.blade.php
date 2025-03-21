@extends('backend.layouts.master')

@section('title', 'Order Detail')

@section('main-content')
    <div class="card">
        </h5>
        <h5 class="card-header">Đơn hàng <a href="{{ route('order.pdf', $order->id) }}"
                class=" btn btn-sm btn-primary shadow-sm float-right"><i class="fas fa-download fa-sm text-white-50"></i>
                Xuất hóa đơn PDF</a>
        </h5>
        <div class="card-body">
            @if ($order)
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Số hóa đơn</th>
                            <th>Tên khách hàng</th>
                            <th>Email</th>
                            <th>Số lượng</th>
                            <th>Phí vận chuyển</th>
                            <th>Tổng</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->order_number }}</td>
                            <td>{{ $order->first_name }} {{ $order->last_name }}</td>
                            <td>{{ $order->email }}</td>
                            <td>{{ $order->quantity }}</td>
                            <td>{{ number_format($order->shipping->price, 0) }}đ</td>
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
                            <td>
                                <a href="{{ route('order.edit', $order->id) }}"
                                    class="btn btn-primary btn-sm float-left mr-1"
                                    style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit"
                                    data-placement="bottom"><i class="fas fa-edit"></i></a>
                                {{--                <form method="POST" action="{{route('order.destroy',[$order->id])}}"> --}}
                                {{--                  @csrf --}}
                                {{--                  @method('delete') --}}
                                {{--                      <button class="btn btn-danger btn-sm dltBtn" data-id={{$order->id}} style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button> --}}
                                {{--                </form> --}}
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
                            <th>Trạng thái</th>
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
                                <td>
                                    @if ($order_item->product->status == 'active')
                                        <span class="badge badge-success">{{ $order_item->product->status }}</span>
                                    @else
                                        <span class="badge badge-warning">{{ $order_item->product->status }}</span>
                                    @endif
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
                                            <td>Số hóa đơn</td>
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
                                        <tr>
                                            <td>Phí vận chuyển</td>
                                            <td> : {{ number_format($order->shipping->price, 0) }}đ</td>
                                        </tr>
                                        <tr>
                                            <td>Mã giảm giá</td>
                                            <td> : {{ number_format($order->coupon, 0) }}đ</td>
                                        </tr>
                                        <tr>
                                            <td>Tổng tiền</td>
                                            <td> :{{ number_format($order->total_amount, 0) }}đ</td>
                                        </tr>
                                        <tr>
                                            <td>Phương thức thanh toán</td>
                                            <td> : @if ($order->payment_method == 'cod')
                                                    Thanh toán khi nhận hàng
                                                @else
                                                    Paypal
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
                                            <td>Quốc Gia</td>
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
