<!DOCTYPE html>
<html>

<head>
    <title>Hóa đơn điện tử - #1234567</title>
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
    <div class="container invoice-box">
        <!-- Header -->
        <div class="invoice-header">
            <div class="company-logo">
                VIETTEL
            </div>
            <div>
                <h2 class="invoice-title">HÓA ĐƠN ĐIỆN TỬ</h2>
                <p class="invoice-title-sub">HOA DON DIEN TU BAN HANG</p>
            </div>
            <div class="invoice-details">
                <p><strong>Số:</strong> 1234567</p>
                <p><strong>Ngày lập:</strong> 08/03/2025</p>
            </div>
        </div>

        <!-- Seller Information -->
        <div class="company-info">
            <p><strong>Người bán hàng:</strong> TẬP ĐOÀN CÔNG NGHIỆP - VIỄN THÔNG QUÂN ĐỘI</p>
            <p><strong>Địa chỉ:</strong> Số 1 Trần Hữu Dực, Nam Từ Liêm, Thành phố Hà Nội, Việt Nam</p>
            <p><strong>Mã số thuế:</strong> 0100109106</p>
            <p><strong>Điện thoại:</strong> 0981234567</p>
            <p><strong>Email:</strong> support@viettel.com.vn</p>
            <p>(Tra cứu hóa đơn tại: https://viettel.com/invoice)</p>
        </div>

        <!-- Buyer Information -->
        <div class="buyer-info">
            <p><strong>Người mua hàng:</strong> NGUYỄN VĂN A</p>
            <p><strong>Địa chỉ:</strong> 15 Đường 5/9, KDC Carynland Hills, Phường 18, Quận Việt Quất, TP. Hà Nội</p>
            <p><strong>Mã số thuế:</strong> 123456789</p>
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
                <tr>
                    <td>1</td>
                    <td class="text-left">SUMMER GALAXY NOTE 14 Plus</td>
                    <td>Chiếc</td>
                    <td>1</td>
                    <td class="text-right">13,750,000</td>
                    <td class="text-right">13,750,000</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td class="text-left">SUMMER GALAXY NOTE 14 Plus</td>
                    <td>Chiếc</td>
                    <td>1</td>
                    <td class="text-right">13,750,000</td>
                    <td class="text-right">13,750,000</td>
                </tr>
            </tbody>
        </table>

        <!-- Totals -->
        <div class="totals">
            <p>Tạm tính: 27,500,000 VNĐ</p>
            <p>Thuế GTGT (10%): 2,750,000 VNĐ</p>
            <p>Tổng cộng: 30,250,000 VNĐ</p>
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
                <p>Ký ngày 08-03-2025</p>
            </div>
        </div>
    </div>
</body>

</html>
