<!DOCTYPE html>
<html>

<head>
    <title>Xác nhận đơn hàng</title>
</head>

<body>
    <p>Xin chào {{ $order->first_name }} {{ $order->last_name }},</p>
    <p>Cảm ơn bạn đã đặt hàng tại cửa hàng của chúng tôi.</p>
    <p>Thông tin đơn hàng của bạn:</p>
    <ul>
        <li>Mã đơn hàng: <strong>{{ $order->order_number }}</strong></li>
        <li>Tổng tiền: <strong>{{ number_format($order->total_amount, 0, ',', '.') }} VND</strong></li>
        <li>Trạng thái: <strong>{{ $order->status }}</strong></li>
    </ul>
    <p>Hóa đơn chi tiết được đính kèm trong email này.</p>
    <p>Chúc bạn một ngày tốt lành!</p>
</body>

</html>
