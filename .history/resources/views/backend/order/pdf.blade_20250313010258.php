<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hóa Đơn Điện Tử</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: #f8f9fa;
        }

        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
        }

        .invoice-header {
            border-bottom: 2px solid #dc3545;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .invoice-title {
            color: #dc3545;
            font-size: 26px;
            font-weight: bold;
            text-align: center;
        }

        .table th {
            background: #dc3545;
            color: #fff;
        }

        .signature {
            margin-top: 50px;
            text-align: right;
        }

        .qr-code {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container invoice-box">
        <div class="row invoice-header">
            <div class="col-md-6">
                <h4><strong>CÔNG TY TNHH ABC</strong></h4>
                <p>Địa chỉ: 123 Nguyễn Trãi, Hà Nội</p>
                <p>SĐT: 0987 654 321</p>
                <p>Email: contact@abc.com</p>
            </div>
            <div class="col-md-6 text-right">
                <h2 class="invoice-title">HÓA ĐƠN ĐIỆN TỬ</h2>
                <p><strong>Mã hóa đơn:</strong> #123456</p>
                <p><strong>Ngày lập:</strong> 13/03/2025</p>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-6">
                <p><strong>Người mua hàng:</strong> Nguyễn Văn A</p>
                <p><strong>Địa chỉ:</strong> 456 Lê Lợi, TP. HCM</p>
                <p><strong>Điện thoại:</strong> 0901234567</p>
                <p><strong>Email:</strong> nguyenvana@email.com</p>
            </div>
        </div>

        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Sản phẩm</th>
                    <th class="text-center">Số lượng</th>
                    <th class="text-right">Đơn giá (VNĐ)</th>
                    <th class="text-right">Thành tiền (VNĐ)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Samsung Galaxy Note 10</td>
                    <td class="text-center">1</td>
                    <td class="text-right">15,000,000</td>
                    <td class="text-right">15,000,000</td>
                </tr>
                <tr>
                    <td>Samsung Galaxy Note 9</td>
                    <td class="text-center">1</td>
                    <td class="text-right">8,500,000</td>
                    <td class="text-right">8,500,000</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" class="text-right">Tạm tính:</th>
                    <th class="text-right">23,500,000 VNĐ</th>
                </tr>
                <tr>
                    <th colspan="3" class="text-right">Phí vận chuyển:</th>
                    <th class="text-right">50,000 VNĐ</th>
                </tr>
                <tr>
                    <th colspan="3" class="text-right">Tổng tiền:</th>
                    <th class="text-right"><strong>23,550,000 VNĐ</strong></th>
                </tr>
            </tfoot>
        </table>

        <div class="row">
            <div class="col-md-6 text-center qr-code">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=https://example.com/invoice/123456"
                    alt="QR Code">
                <p>Quét mã QR để kiểm tra hóa đơn</p>
            </div>
            <div class="col-md-6 signature">
                <p>-----------------------------------</p>
                <h5>Đại diện cửa hàng</h5>
            </div>
        </div>
    </div>
</body>

</html>
