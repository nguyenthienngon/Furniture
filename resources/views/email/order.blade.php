<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác nhận đơn hàng #{{ $order->order_number }}</title>
    <!-- Thêm Font Awesome để sử dụng icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #e0e0e0;
            border-radius: 5px;
        }

        .header {
            background-color: #f5f5f5;
            padding: 10px;
            text-align: center;
            border-bottom: 2px solid #007bff;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #777;
            margin-top: 20px;
        }

        .order-details {
            margin: 20px 0;
        }

        .order-details li {
            margin-bottom: 10px;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        /* CSS cho icon mạng xã hội */
        .social-icons a {
            margin: 0 10px;
            text-decoration: none;
        }

        .fa-facebook-f {
            color: #1877f2;
            /* Màu xanh của Facebook */
        }

        .fa-instagram {
            color: #e4405f;
            /* Màu hồng của Instagram */
        }

        .fa-twitter {
            color: #1da1f2;
            /* Màu xanh của Twitter */
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>Xác nhận đơn hàng</h2>
        </div>

        <p>Xin chào <strong>{{ $order->first_name }} {{ $order->last_name }}</strong>,</p>
        <p>Cảm ơn bạn đã tin tưởng và đặt hàng tại <a href="#">Cửa hàng của chúng tôi</a>. Chúng tôi rất vui được
            phục vụ bạn!</p>

        <div class="order-details">
            <p><strong>Thông tin đơn hàng của bạn:</strong></p>
            <ul>
                <li>Mã đơn hàng: <strong>{{ $order->order_number }}</strong></li>
                <li>Tổng tiền: <strong>{{ number_format($order->total_amount, 0, ',', '.') }} VND</strong></li>
                <li>Trạng thái: <strong>{{ $order->status }}</strong></li>
            </ul>
        </div>

        <p>Hóa đơn chi tiết đã được đính kèm trong email này. Vui lòng kiểm tra kỹ thông tin.</p>
        <p>Nếu bạn có bất kỳ câu hỏi nào, đừng ngần ngại liên hệ với chúng tôi qua email <a
                href="mailto:support@cuahang.com">support@cuahang.com</a> hoặc số hotline: 0123 456 789.</p>
        <p>Chúc bạn một ngày tốt lành!</p>

        <div class="footer">
            <p>Trân trọng,<br>Đội ngũ Cửa hàng của chúng tôi<br>
                <a href="https://www.aritsan.com">www.aritsan.com</a>
            </p>
            <div class="social-icons">
                <a href="https://facebook.com/aritsan" target="_blank"><i class="fab fa-facebook-f"></i></a>
                <a href="https://instagram.com/aritsan" target="_blank"><i class="fab fa-instagram"></i></a>
                <a href="https://twitter.com/aritsan" target="_blank"><i class="fab fa-twitter"></i></a>
            </div>
        </div>
    </div>
</body>

</html>
