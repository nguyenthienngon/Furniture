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
            font-family: 'DejaVu Sans', Arial, sans-serif;
        }

        .invoice-box {
            padding: 30px;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            background: #fff;
        }

        .invoice-header {
            border-bottom: 2px solid #28a745;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .company-info {
            font-size: 14px;
        }

        .invoice-title {
            color: #28a745;
            font-size: 28px;
            font-weight: bold;
            text-align: center;
        }

        .invoice-info p {
            margin: 5px 0;
        }

        .table th {
            background: #28a745;
            color: #fff;
            text-align: center;
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
            <!-- Header -->
            <div class="row invoice-header">
                <div class="col-6">
                    <h4 class="company-info">
                        <strong>CÔNG TY TNHH ABC</strong><br>
                        Địa chỉ: 123 Nguyễn Trãi, Hà Nội<br>
                        SĐT: 0987 654 321<br>
                        Email: contact@abc.com
                    </h4>
                </div>
                <div class="col-6 text-right">
                    <h2 class="invoice-title">HÓA ĐƠN ĐIỆN TỬ</h2>
                    <p><strong>Mã hóa đơn:</strong> #{{ $order->cart_id }}</p>
                    <p><strong>Ngày lập:</strong> {{ $order->created_at->format('d/m/Y') }}</p>
                </div>
            </div>

            <!-- Thông tin người mua -->
            <div class="row mt-3 invoice-info">
                <div class="col-6">
                    <p><strong>Người mua hàng:</strong> {{ $order->first_name }} {{ $order->last_name }}</p>
                    <p><strong>Địa chỉ:</strong> {{ $order->address1 }}, {{ $order->country }}</p>
                    <p><strong>Điện thoại:</strong> {{ $order->phone }}</p>
                    <p><strong>Email:</strong> {{ $order->email }}</p>
                </div>
            </div>

            <!-- Bảng sản phẩm -->
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Đơn giá (VNĐ)</th>
                        <th>Thành tiền (VNĐ)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->cart_info as $cart)
                        @php
                            $product = DB::table('products')->select('title')->where('id', $cart->product_id)->first();
                        @endphp
                        <tr>
                            <td>{{ $product->title }}</td>
                            <td class="text-center">x{{ $cart->quantity }}</td>
                            <td class="text-right">{{ number_format($cart->price, 0, ',', '.') }}</td>
                            <td class="text-right">{{ number_format($cart->price * $cart->quantity, 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-right">Tạm tính:</th>
                        <th class="text-right">{{ number_format($order->sub_total, 0, ',', '.') }} VNĐ</th>
                    </tr>
                    <tr>
                        <th colspan="3" class="text-right">Phí vận chuyển:</th>
                        {{-- <th class="text-right">{{ number_format($order->delivery_charge, 0, ',', '.') }} VNĐ</th> --}}
                    </tr>
                    <tr>
                        <th colspan="3" class="text-right">Tổng tiền:</th>
                        <th class="text-right"><strong>{{ number_format($order->total_amount, 0, ',', '.') }}
                                VNĐ</strong></th>
                    </tr>
                </tfoot>
            </table>

            <!-- Chữ ký -->
            <div class="signature">
                <p>-----------------------------------</p>
                <h5>Đại diện cửa hàng</h5>
            </div>
        </div>
    @else
        <h5 class="text-danger text-center mt-5">Hóa đơn không hợp lệ</h5>
    @endif
</body>

</html>
