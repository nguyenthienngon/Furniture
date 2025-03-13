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
            font-size: 12px;
        }

        .invoice-box {
            padding: 20px;
            border: 1px solid #000;
            background: #fff;
            max-width: 800px;
            margin: 0 auto;
        }

        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .company-logo {
            font-size: 24px;
            font-weight: bold;
            color: #ff0000;
        }

        .invoice-title {
            font-size: 18px;
            font-weight: bold;
            text-align: center;
        }

        .invoice-title-sub {
            font-size: 12px;
            text-align: center;
            margin-top: -5px;
        }

        .invoice-details {
            text-align: right;
            font-size: 12px;
        }

        .company-info,
        .buyer-info {
            margin-bottom: 15px;
        }

        .company-info p,
        .buyer-info p {
            margin: 2px 0;
        }

        .table th {
            background: #000;
            color: #fff;
            text-align: center;
            font-size: 12px;
            padding: 5px;
        }

        .table td {
            padding: 5px;
            text-align: center;
            font-size: 12px;
        }

        .table .text-left {
            text-align: left;
        }

        .table .text-right {
            text-align: right;
        }

        .totals {
            margin-top: 10px;
            font-weight: bold;
        }

        .totals p {
            margin: 2px 0;
            text-align: right;
        }

        .footer-note {
            font-size: 10px;
            text-align: center;
            margin-top: 20px;
        }

        .signatures {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }

        .signature {
            text-align: center;
        }
    </style>
</head>

<body>
    @if ($order)
        <div class="container invoice-box">
            <!-- Header -->
            <div class="invoice-header">
                <div class="company-logo">
                    ARTISAN
                </div>
                <div>
                    <h2 class="invoice-title">HÓA ĐƠN ĐIỆN TỬ</h2>
                    <p class="invoice-title-sub">HOA DON DIEN TU BAN HANG</p>
                </div>
                <div class="invoice-details">
                    <p><strong>Số:</strong> #{{ $order->order_number }}</p>
                    <p><strong>Ngày lập:</strong> {{ $order->created_at->format('d/m/Y') }}</p>
                </div>
            </div>

            <!-- Seller Information -->
            <div class="company-info">
                <p><strong>Người bán hàng:</strong> Tập đoàn xuất nhập khẩu - Ngôn Nguyễn</p>
                <p><strong>Địa chỉ:</strong> Khu II, Đ. 3 Tháng 2, Xuân Khánh, Ninh Kiều, Cần Thơ</p>
                <p><strong>Mã số thuế:</strong> 0100109106</p>
                <p><strong>Điện thoại:</strong> 0981234567</p>
                <p><strong>Email:</strong> support@artisan.com.vn</p>
            </div>

            <!-- Buyer Information -->
            <div class="buyer-info">
                <p><strong>Người mua hàng:</strong> {{ $order->first_name }} {{ $order->last_name }}</p>
                <p><strong>Địa chỉ:</strong> {{ $order->address1 }}, {{ $order->country }}</p>
                <p><strong>Điện thoại:</strong> {{ $order->phone }}</p>
                <p><strong>Email:</strong> {{ $order->email }}</p>
                <!-- Mã số thuế có thể thêm nếu có trong $order -->
            </div>

            <!-- Product Table -->
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên hàng hóa, dịch vụ</th>
                        <th>ĐVT</th>
                        <th>Số lượng</th>
                        <th>Đơn giá</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    @php $stt = 1; @endphp
                    @foreach ($order->cart_info as $cart)
                        @php
                            $product = DB::table('products')->select('title')->where('id', $cart->product_id)->first();
                        @endphp
                        <tr>
                            <td>{{ $stt++ }}</td>
                            <td class="text-left">{{ $product->title }}</td>
                            <td>Chiếc</td>
                            <td class="text-center">{{ $cart->quantity }}</td>
                            <td class="text-right">{{ number_format($cart->price, 0, ',', '.') }}</td>
                            <td class="text-right">{{ number_format($cart->price * $cart->quantity, 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Totals -->
            <div class="totals">
                <p>Tạm tính: {{ number_format($order->sub_total, 0, ',', '.') }} VNĐ</p>
                <p>Thuế GTGT (10%): {{ number_format($order->sub_total * 0.1, 0, ',', '.') }} VNĐ</p>
                <p>Tổng cộng: {{ number_format($order->total_amount, 0, ',', '.') }} VNĐ</p>
            </div>

            <!-- Footer Note -->
            <div class="footer-note">
                <p>(Hóa đơn điện tử không bắt buộc sử dụng con dấu của người bán và người mua)</p>
            </div>

            <!-- Signatures -->
            <div class="signatures">
                <div class="signature">
                    <p>Người mua hàng</p>
                    <p>(Ký, ghi rõ họ tên)</p>
                </div>
                <div class="signature">
                    <p>Người bán hàng</p>
                    <p>(Ký, ghi rõ họ tên)</p>
                    <p>Ký bởi TEST</p>
                    <p>Ký ngày {{ $order->created_at->format('d-m-Y') }}</p>
                </div>
            </div>
        </div>
    @else
        <h5 class="text-danger text-center mt-5">Hóa đơn không hợp lệ</h5>
    @endif
</body>

</html>
