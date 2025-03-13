<!DOCTYPE html>
<html>

<head>
    <title>Hóa đơn điện tử - @if ($order)
            #{{ $order->cart_id }}
        @endif
    </title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .invoice-box {
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
        }

        .invoice-header {
            border-bottom: 2px solid #28a745;
            padding-bottom: 10px;
        }

        .invoice-logo {
            max-width: 150px;
        }

        .invoice-title {
            color: #28a745;
            font-size: 28px;
            font-weight: bold;
        }

        .invoice-info p {
            margin: 5px 0;
        }

        .table th {
            background: #28a745;
            color: #fff;
        }

        .signature {
            text-align: right;
            margin-top: 50px;
        }

        .qr-code {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    @if ($order)
        <div class="container invoice-box">
            <div class="row invoice-header">
                <div class="col-6">
                    <img class="invoice-logo" src="{{ asset('backend/img/logo.png') }}" alt="Logo">
                </div>
                <div class="col-6 text-right">
                    <h2 class="invoice-title">HÓA ĐƠN ĐIỆN TỬ</h2>
                </div>
            </div>

            <div class="row mt-3 invoice-info">
                <div class="col-6">
                    <p><strong>Người mua hàng:</strong> {{ $order->first_name }} {{ $order->last_name }}</p>
                    <p><strong>Địa chỉ:</strong> {{ $order->address1 }}, {{ $order->country }}</p>
                    <p><strong>Điện thoại:</strong> {{ $order->phone }}</p>
                    <p><strong>Email:</strong> {{ $order->email }}</p>
                </div>
                <div class="col-6 text-right">
                    <p><strong>Mã hóa đơn:</strong> #{{ $order->cart_id }}</p>
                    <p><strong>Ngày tạo:</strong> {{ $order->created_at->format('d/m/Y') }}</p>
                </div>
            </div>

            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Đơn giá</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->cart_info as $cart)
                        @php
                            $product = DB::table('products')->select('title')->where('id', $cart->product_id)->get();
                        @endphp
                        <tr>
                            <td>
                                @foreach ($product as $pro)
                                    {{ $pro->title }}
                                @endforeach
                            </td>
                            <td>x{{ $cart->quantity }}</td>
                            <td>{{ number_format($cart->price, 0) }}đ</td>
                            <td>{{ number_format($cart->price * $cart->quantity, 0) }}đ</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-right">Tạm tính:</th>
                        <th>{{ number_format($order->sub_total, 0) }}đ</th>
                    </tr>
                    <tr>
                        <th colspan="3" class="text-right">Phí vận chuyển:</th>
                        <th>{{ number_format($order->delivery_charge, 0) }}đ</th>
                    </tr>
                    <tr>
                        <th colspan="3" class="text-right">Tổng tiền:</th>
                        <th><strong>{{ number_format($order->total_amount, 0) }}đ</strong></th>
                    </tr>
                </tfoot>
            </table>
            @php
                use SimpleSoftwareIO\QrCode\Facades\QrCode;
            @endphp

            <div class="qr-code">
                <p>Quét mã QR để kiểm tra đơn hàng:</p>
                <img
                    src="data:image/png;base64, {{ base64_encode(QrCode::format('png')->size(150)->generate(route('admin.product.order.show', $order->id))) }}">

            </div>

            <div class="signature">
                <p>-----------------------------------</p>
                <h5>Chữ ký (đại diện cửa hàng)</h5>
            </div>
        </div>
    @else
        <h5 class="text-danger text-center mt-5">Hóa đơn không hợp lệ</h5>
    @endif
</body>

</html>
