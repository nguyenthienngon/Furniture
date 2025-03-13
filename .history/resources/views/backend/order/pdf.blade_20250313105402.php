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
            margin: 0;
        }

        .invoice-box {
            padding: 2px 10px 10px 10px;
            /* Reduced top padding from 5px to 2px */
            border: 1px solid #000;
            background: #fff;
            max-width: 800px;
            margin: 0 auto;
        }

        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            /* Align items to the top */
            margin-bottom: 2px;
        }

        .company-logo {
            font-size: 24px;
            font-weight: bold;
            color: #000;
            margin: 0;
            /* Remove default margin */
        }

        .invoice-title {
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            margin: 0;
            /* Remove default margin */
        }

        .invoice-title-sub {
            font-size: 12px;
            text-align: center;
            margin-top: -2px;
            /* Reduced from -5px to -2px for tighter spacing */
        }

        .invoice-details {
            text-align: right;
            font-size: 12px;
            margin: 0;
            /* Remove default margin */
        }

        .company-info,
        .buyer-info {
            margin-bottom: 5px;
        }

        .company-info p,
        .buyer-info p {
            margin: 1px 0;
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

        .totals-table {
            margin-top: 5px;
        }

        .totals-table td {
            padding: 5px;
            font-weight: bold;
        }

        .footer-note {
            font-size: 10px;
            text-align: center;
            margin-top: 10px;
        }

        .signatures {
            display: flex;
            justify-content: space-between;
            margin-top: 5px;
            /* Reduced spacing */
            position: relative;
        }

        .signature-buyer,
        .signature-seller {
            width: 40%;
            text-align: center;
        }

        .signature-seller {
            text-align: right;
        }

        .signature-date {
            border: 1px solid #000;
            padding: 2px 5px;
            display: inline-block;
            margin-top: 5px;
        }
    </style>
</head>

<body>
    @if ($order)
        <div class="container invoice-box">
            <!-- Header -->
            <div class="invoice-header">
                <div class="company-logo">ARTISAN</div>
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
                <hr>
            </div>

            <!-- Buyer Information -->
            <div class="buyer-info">
                <p><strong>Người mua hàng:</strong> {{ $order->first_name }} {{ $order->last_name }}</p>
                <p><strong>Địa chỉ:</strong> {{ $order->address1 }}, {{ $order->country }}</p>
                <p><strong>Điện thoại:</strong> {{ $order->phone }}</p>
                <p><strong>Email:</strong> {{ $order->email }}</p>
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

            <!-- Totals Table -->
            <table class="table table-bordered totals-table">
                <tbody>
                    <tr>
                        <td class="text-left">Tạm tính</td>
                        <td class="text-right">{{ number_format($order->sub_total, 0, ',', '.') }} VNĐ</td>
                    </tr>
                    <tr>
                        <td class="text-left">Thuế GTGT (10%)</td>
                        <td class="text-right">{{ number_format($order->sub_total * 0.1, 0, ',', '.') }} VNĐ</td>
                    </tr>
                    <tr>
                        <td class="text-left">Tổng cộng</td>
                        <td class="text-right">{{ number_format($order->total_amount, 0, ',', '.') }} VNĐ</td>
                    </tr>
                    <tr>
                        <td class="text-left">Số tiền bằng chữ</td>
                        <td class="text-right">
                            @php
                                $amount_in_words = 'Chín triệu bảy trăm năm mươi mốt nghìn hai trăm đồng'; // Placeholder
                            @endphp
                            {{ $amount_in_words }}
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- Footer Note -->
            <div class="footer-note">
                <p>(Hóa đơn điện tử không bắt buộc sử dụng con dấu của người bán và người mua)</p>
            </div>

            <!-- Signatures -->
            <div class="signatures">
                <div class="signature-buyer">
                    <p>Người mua hàng</p>
                    <p>(Ký, ghi rõ họ tên)</p>
                </div>
                <div class="signature-seller">
                    <p>Người bán hàng</p>
                    <p>(Ký, ghi rõ họ tên)</p>
                    <p>Ký bởi: {{ $order->first_name }} {{ $order->last_name }}</p> <!-- Dynamic signature -->
                    <p>(Ký, ghi rõ họ tên)</p>
                </div>
            </div>
        </div>
    @else
        <h5 class="text-danger text-center mt-5">Hóa đơn không hợp lệ</h5>
    @endif
</body>

</html>
